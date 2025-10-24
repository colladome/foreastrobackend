<?php

namespace App\Http\Controllers\Auth\Backend;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Services\MailService;

class AuthController extends Controller
{



    public $mailService;


    public function __construct()
    {

        $this->mailService = new MailService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Admin Login
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return redirect()->route('admin.dashboard');
        }


        return redirect()->route('admin.index')->with('error', 'Login details are not valid');
    }

    /**
     * Admin Logout
     */

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('admin.index');
    }

    /**
     * Admin forget password 
     */

    public function forgetPasswordForm()

    {

        return view('auth.passwords.email');
    }



    /**
     * Admin Forget Password
     */


    public function forgetPassword(Request $request)

    {

        $request->validate([

            'email' => 'required|email|exists:users',

        ]);
        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()

        ]);
        $mailData = [
            'token' => $token,
        ];

        $toName = 'Test';
        $toEmail = $request->email;
        $subject = 'Reset Password';
        $body = "Please Reset Your Password.<br>";
        $body .= "<a href='" . route('admin.resetPasswordForm', $token) . "'>Reset Password</a>";

        $this->mailService->sendEmail($toName, $toEmail, $subject, $body);


        return back()->with('success', 'We have e-mailed your password reset link!');
    }


    public function resetPasswordForm($token)
    {

        return view('auth.passwords.reset', ['token' => $token]);
    }


    /**
     * Admin new Password 
     */


    public function resetPassword(Request $request)

    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);


        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return redirect()->route('admin.forgetPasswordForm')->with('error', 'Invalid token. Please Send Again Reset Link!');
        }

        $user = User::where('email', $updatePassword->email)
            ->update(['password' => Hash::make($request->password)]);
        DB::table('password_reset_tokens')->where(['email' => $updatePassword->email])->delete();
        return redirect()->route('admin.index')->with('success', 'Your password has been changed!');
    }

    /**
     * change Password
     */

    public function changePassword()
    {
        return view('backend.admin_profile.changePassword');
    }

    /**
     * change password save
     */
    public function changePasswordSave(Request $request)
    {
        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {

            $hashedPassword = Hash::make($request->new_password);
            $user->update([
                'password' => $hashedPassword,
            ]);
            return redirect()->back()->with('success', 'Password has been changed.');
        } else {
            return redirect()->back()->with('error', 'Old password is incorrect.');
        }
    }

    /**
     * profile edit
     */

    public function profileEdit()
    {
        $user = Auth::user();
        return view('backend.admin_profile.edit', compact('user'));
    }

    /**
     * profile update
     */
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile_number = $request->mobile_number;
        $user->save();
        return back()->with('success', 'profile update successfully');
    }
}
