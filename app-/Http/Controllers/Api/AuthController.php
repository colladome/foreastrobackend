<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use App\Models\UserProfile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\File;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    /***
     * user register 
     */

    public function register(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'mobile_number' => 'required|unique:users',
                    'email' => 'required|email|unique:users',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'error' => [
                        'code' => 401,
                        'message' => 'validation error',
                    ],
                    'data' => $validator->errors()
                ], 401);
            }



            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'user_type' => 'user',
                'password' => Hash::make('sky@12345'),
            ]);

            UserProfile::create([
                'user_id' => $user->id,
            ]);



            //otp system      

            // $oto = Otp::where('user_id', $user->id)->first();
            // if (!empty($otp)) {
            //     $otp->delete();
            // }
            //  $code = uniqid(rand(), true);
            // $otp = strtoupper(substr($code, 0, 6));
            $otp = 1234;

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


            return response()->json([
                'status' => true,
                'data' => [
                    'message' => 'send verifaction code on your mobile.',
                    'user_id' => $user->id

                ],

            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => [
                    'code' => 500,
                    'message' =>  $th->getMessage(),
                ]
            ], 500);
        }
    }








    /**
     * Login with otp
     */

    public function loginWithOtp(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'phone' => 'required',

                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'error' => [
                        'code' => 401,
                        'message' => 'validation error',
                    ],
                    'data' => $validator->errors()
                ], 401);
            }

            $user = User::where(['mobile_number' => $request->phone, 'user_type' => $request->type])->first();

            if (empty($user)) {

                return response()->json([
                    'status' => false,
                    'error' => [
                        'code' => 401,
                        'message' => 'Invalid Phone number',
                    ],
                    'data' => $validator->errors()
                ], 401);
            }

            // $oto = Otp::where('user_id', $user->id)->first();
            // if (!empty($otp)) {
            //     $otp->delete();
            // }
            //  $code = uniqid(rand(), true);
            // $otp = strtoupper(substr($code, 0, 6));
            $otp = 1234;

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


            return response()->json([
                'status' => true,
                'user_id' => $user->id,
                'message' => 'Otp Send Your Registerd Mobile Number successfully!',

            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => [
                    'code' => 500,
                    'message' =>  $th->getMessage(),
                ]
            ], 500);
        }
    }


    /**
     * verify otp
     */

    public function loginVerifyOtp(Request $request)
    {
        try {
            $user = User::where('id', $request->user_id)->first();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'error' => [
                        'code' => 401,
                        'message' => 'Invalid User!',
                    ],

                ], 401);
            }


            $otp = OTP::where('user_id', $user->id)->latest()->first();

            if ($otp && !$otp->isExpired() && $otp->otp_secret === $request->otp) {
                $otp->markAsVerified();
                $token =  $user->createToken('MyApp')->plainTextToken;

                return response()->json(
                    [
                        'status' => true,
                        'data' => [
                            'message' => 'User Login successfully.',
                            'name' => $user->name,
                            'email' => $user->email,
                            'phone' => $user->mobile_number,
                            'user_id' => $user->id

                        ],

                        'token' => $token

                    ],
                    201
                );
            } else {
                return response()->json([
                    'status' => false,
                    'error' => [
                        'code' => 401,
                        'message' => 'Invalid OTP!',
                    ],

                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => [
                    'code' => 500,
                    'message' =>  $th->getMessage(),
                ]
            ], 500);
        }
    }


    /**
     * User Logout
     */


    public function logout()
    {
        try {
            $user = Auth::user();
            // Revoke the user's token
            $user->tokens()->delete();
            return response()->json([
                'status' => true,
                'message' => 'User Logout successfully!',

            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => [
                    'code' => 500,
                    'message' =>  $th->getMessage(),
                ]
            ], 500);
        }
    }

    //for vendors








    /**
     * vendor login
     */


    public function vendorLogin(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required',
                    'password' => 'required',
                ]
            );

            $credentials = $request->only('email', 'password');
            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
                'user_type' => 'vendor'
            ])) {

                $user = Auth::user();

                $token =  $user->createToken('MyApp')->plainTextToken;

                return response()->json(
                    [
                        'status' => true,
                        'data' => [
                            'message' => 'User Login successfully.',
                            'name' => $user->name,
                            'email' => $user->email,
                            'phone' => $user->mobile_number,
                            'user_id' => $user->id
                        ],

                        'token' => $token

                    ],
                    201
                );

                //return redirect()->route('vendor.dashboard');
            }
            return response()->json([
                'status' => false,
                'error' => [
                    'code' => 401,
                    'message' => 'Invalid User!',
                ],

            ], 401);

            //return redirect()->route('vendor.index')->with('error', 'Login details are not valid');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => [
                    'code' => 500,
                    'message' =>  $th->getMessage(),
                ]
            ], 500);
        }
    }
}
