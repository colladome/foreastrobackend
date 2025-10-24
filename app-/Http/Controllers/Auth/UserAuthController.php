<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use App\Models\UserProfile;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.user.login_register');
    }




    /**
     * genrate otp
     */

    public function otp(Request $request)
    {
        // print_r($request->all());
        // die;

        $user = User::where(['mobile_number' => $request->mobile, 'user_type' => 'user'])->first();
        if (!$user) {
            return back()->with('error', 'User not Registerd!');
        }

        $otp = 123456;

        $currentDateTime = Carbon::now();
        $expireAtDateTime = $currentDateTime->addMinutes(2);
        $expireAtDateTime = $expireAtDateTime->toDateTimeString();
        // $otpCode = $this->otpUtility->genrateOtp();
        // $smsString          = "Your confidential OTP for Nirman website is:" . $otpCode;
        // $smsMobile          = $jobseekerMobile;
        Otp::create([
            'user_id' => $user->id,
            'otp_secret' => $otp,
            'expires_at' => $expireAtDateTime
        ]);
        return view('auth.user.otp', compact('user'))->with('success', 'We have send otp on your registerd Mobile Number');
    }
    /**
     * verify otp
     */

    public function verifyOtp(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid User!');
        }
        $otp = OTP::where('user_id', $user->id)->latest()->first();

        if ($otp && !$otp->isExpired() && $otp->otp_secret === $request->otp) {
            $otp->markAsVerified();
            Auth::login($user);
            return redirect()->route('userDashboard');
        } else {
            return redirect()->route('login')->with('error', 'Invalid OTP');
        }
    }






    /**
     *  Dashboard
     */

    public function userDashboard()
    {

        $user = Auth::user();
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
        $orderCount = Order::where('user_id', $user->id)->count();

        return view('frontend.dashboard', compact('user', 'wishlistCount', 'orderCount')); //redirect('/home');

    }

    /**
     * user logout
     */


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'user_type' => 'user',
        ]);


        UserProfile::create([
            'user_id' => $user->id,

        ]);



        return back()->with('success', 'Registration has done successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function callbackFromGoogle()
    {


        try {

            $user = Socialite::driver('google')->user();



            $finduser = User::where('gauth_id', $user->id)->first();

            if ($finduser) {

                Auth::login($finduser);

                return redirect('/');
            } else {
                $checkUser = User::where('email', $user->email)->first();

                if (!empty($checkUser)) {
                    $checkUser->gauth_id = $user->id;
                    $checkUser->gauth_type = 'google';
                    $checkUser->save();

                    Auth::login($checkUser);
                    return redirect('/');
                } else {
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'gauth_id' => $user->id,
                        'gauth_type' => 'google',
                        'user_type' => 'user',
                        'password' => Hash::make('ramramram')
                    ]);



                    Auth::login($newUser);

                    return redirect('/');
                }
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
