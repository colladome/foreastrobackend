<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Astrologer;
use App\Models\AstrologerCoupon;
use App\Models\Backend\Banner;
use App\Models\Backend\Blog;
use App\Models\Celebrity;
use App\Models\Communication;
use App\Models\Contact;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use App\Models\UserProfile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\File;
use App\Models\Follower;
use App\Models\Payment;
use App\Models\Payout;
use App\Models\Ramedy;
use App\Models\Astrolog;
use App\Models\Review;
use App\Models\Testimonial;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{


    public function createProfile(Request $request)
    {

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'date_of_birth' => 'required',
                    'birth_time' => 'required',
                    //'country' => 'required',
                    'state' => 'required',
                    'city' => 'required',
                    'mobile_number' => [
                        'required',
                        Rule::unique('users')->ignore($request->user_id),
                    ],
                    'email' => [
                        'required',
                        'email',
                        Rule::unique('users')->ignore($request->user_id),
                    ],
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

            $profileImage = $request->file('profile_image');
            if ($profileImage) {
                $uuid = Str::uuid()->toString();
                $extension = $request->file('profile_image')->extension();
                $fileName = $uuid . 'profile_image' . '.' . $extension;
                $documentPath = 'user';
                $filePath = $documentPath . '/' . $fileName;
                $storedFilePath = $profileImage->storeAs($documentPath, $fileName, 'public');
            }

            User::where('id', $request->user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                // 'country' => $request->country,
                'profile_img' => $filePath ?? null,
                'state' => $request->state,
                'city' => $request->city,
                'wallet' => '100',
                'date_of_birth' => $request->date_of_birth,
                'birth_time' => $request->birth_time,
                'mobile_number' => $request->mobile_number,
                'user_type' => 'user',
                'gender' => $request->gender,
                'sign' => $request->sign,
                'is_profile_created' => '1',

            ]);



            $user = User::findOrFail($request->user_id);


            return response()->json([
                'status' => true,
                'message' => 'User Profile successfully!',
                'data' => [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->mobile_number,

                ]

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
     * Login
     */

    public function login(Request $request)
    {
        
if(!empty($request->version))
{
       $user = User::where('mobile_number', $request->phone)->update([
           'version' => $request->version,
           ]);
}
           
          $user = User::where('mobile_number', $request->phone)->first();
          
        
           
         if(!empty($user))
         {
          if($user->version == '0' || $user->version == '')
          {
              $url = "https://sms.staticking.com/index.php/smsapi/httpapi/";
                $fields = array(
                    'secret' => 'wmrZhOgKDs7Ve2sqkOcn',
                    'sender' => 'FOREAS',
                    'tempid' => '1707173832889301660',
                    'receiver' => $user->mobile_number,
                    'route' => 'TA',
                    'msgtype' => '1',
                    'sms' => 'Dear User, Your app is outdated! Update now for a better experience: https://play.google.com/store/apps/details?id=com.foreastro.foreastrouserside'
                );

                $fields_string = http_build_query($fields);

                // Initialize cURL
                $ch = curl_init();

                // Set the URL
                curl_setopt($ch, CURLOPT_URL, $url);

                // Set the method to POST
                curl_setopt($ch, CURLOPT_POST, 1);

                // Attach the fields
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

                // Return the response instead of printing
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                // Execute the request
                $response = curl_exec($ch);
                curl_close($ch);
                
                 return response()->json([
                'status' => true,
                'user_id' => $user->id,
                'message' => 'please update your application'
                //'is_profile_created' => $user->is_profile_created == 1  ? true : false,


            ], 201);
          }
         }
           
           
       
         
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

            $user = User::where(['mobile_number' => $request->phone])->first();


            if (empty($user)) {

                $user = User::create([
                    'mobile_number' => $request->phone,
                    'is_profile_created' => '0',
                    'version' => $request->version,
                    'user_type' => 'user'

                ]);


                $otp = rand(1000, 9999);

                $currentDateTime = Carbon::now();
                $expireAtDateTime = $currentDateTime->addMinutes(10);
                $expireAtDateTime = $expireAtDateTime->toDateTimeString();

                Otp::create([
                    'user_id' => $user->id,
                    'otp_secret' => $otp,
                    'expires_at' => $expireAtDateTime
                ]);





                $url = "https://sms.staticking.com/index.php/smsapi/httpapi/";
                $fields = array(
                    'secret' => 'wmrZhOgKDs7Ve2sqkOcn',
                    'sender' => 'FOREAS',
                    'tempid' => '1707172060857103586',
                    'receiver' => $user->mobile_number,
                    'route' => 'TA',
                    'msgtype' => '1',
                    'sms' => 'Welcome to ForeAstro! Your OTP for login is ' . $otp . '. Please use it to log in to your account. This OTP is valid for 10 minutes.'
                );

                $fields_string = http_build_query($fields);

                // Initialize cURL
                $ch = curl_init();

                // Set the URL
                curl_setopt($ch, CURLOPT_URL, $url);

                // Set the method to POST
                curl_setopt($ch, CURLOPT_POST, 1);

                // Attach the fields
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

                // Return the response instead of printing
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                // Execute the request
                $response = curl_exec($ch);
                curl_close($ch);

                //$token =  $user->createToken('MyApp')->plainTextToken;

                return response()->json([
                    'status' => true,
                    'user_id' => $user->id,
                    // 'phone' => $user->mobile_number,
                    // 'is_profile_created' => $user->is_profile_created == 1  ? true : false,
                    // 'token' => $token
                ], 201);
            }



            $otp = rand(1000, 9999);

            $currentDateTime = Carbon::now();
            $expireAtDateTime = $currentDateTime->addMinutes(10);
            $expireAtDateTime = $expireAtDateTime->toDateTimeString();

            Otp::create([
                'user_id' => $user->id,
                'otp_secret' => $otp,
                'expires_at' => $expireAtDateTime
            ]);





            $url = "https://sms.staticking.com/index.php/smsapi/httpapi/";
            $fields = array(
                'secret' => 'wmrZhOgKDs7Ve2sqkOcn',
                'sender' => 'FOREAS',
                'tempid' => '1707172060857103586',
                'receiver' => $user->mobile_number,
                'route' => 'TA',
                'msgtype' => '1',
                'sms' => 'Welcome to ForeAstro! Your OTP for login is ' . $otp . '. Please use it to log in to your account. This OTP is valid for 10 minutes.'
            );

            $fields_string = http_build_query($fields);

            // Initialize cURL
            $ch = curl_init();

            // Set the URL
            curl_setopt($ch, CURLOPT_URL, $url);

            // Set the method to POST
            curl_setopt($ch, CURLOPT_POST, 1);

            // Attach the fields
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

            // Return the response instead of printing
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute the request
            $response = curl_exec($ch);

            curl_close($ch);


            return response()->json([
                'status' => true,
                'user_id' => $user->id,
                // 'is_profile_created' => $user->is_profile_created == 1  ? true : false,


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

            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    'otp' => 'required',

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


            $otp = Otp::where('user_id', $user->id)->latest()->first();

            if ($otp && !$otp->isExpired() && $otp->otp_secret === $request->otp) {
                $otp->markAsVerified();
                $token =  $user->createToken('MyApp')->plainTextToken;

                return response()->json(
                    [
                        'status' => true,
                        'data' => [
                            'user_id' => $user->id,
                            'phone' => $user->mobile_number,
                            'is_profile_created' => $user->is_profile_created == 1  ? true : false,
                            'token' => $token
                        ],

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





    public function userResendOtp(Request $request)
    {

        try {


            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',


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

            $user = User::where('id', $request->user_id)->first();


            $otp = rand(1000, 9999);

            $currentDateTime = Carbon::now();
            $expireAtDateTime = $currentDateTime->addMinutes(10);
            $expireAtDateTime = $expireAtDateTime->toDateTimeString();

            Otp::create([
                'user_id' => $user->id,
                'otp_secret' => $otp,
                'expires_at' => $expireAtDateTime
            ]);





            $url = "https://sms.staticking.com/index.php/smsapi/httpapi/";
            $fields = array(
                'secret' => 'wmrZhOgKDs7Ve2sqkOcn',
                'sender' => 'FOREAS',
                'tempid' => '1707172060857103586',
                'receiver' => $user->mobile_number,
                'route' => 'TA',
                'msgtype' => '1',
                'sms' => 'Welcome to ForeAstro! Your OTP for login is ' . $otp . '. Please use it to log in to your account. This OTP is valid for 10 minutes.'
            );

            $fields_string = http_build_query($fields);

            // Initialize cURL
            $ch = curl_init();

            // Set the URL
            curl_setopt($ch, CURLOPT_URL, $url);

            // Set the method to POST
            curl_setopt($ch, CURLOPT_POST, 1);

            // Attach the fields
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

            // Return the response instead of printing
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute the request
            $response = curl_exec($ch);

            curl_close($ch);







            return response()->json([
                'status' => true,
                'user_id' => $user->id,
                // 'is_profile_created' => $user->is_profile_created == 1  ? true : false,


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






    public function loginWithGoogle(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required',
                    'token' => 'required',


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

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $user = User::create([

                    'email' => $request->email,
                    'user_type' => 'user',
                    'gauth_id' => $request->token,
                    'socail_media_auth_type' => 'google'

                ]);

                $token =  $user->createToken('MyApp')->plainTextToken;

                return response()->json([
                    'status' => true,
                    'user_id' => $user->id,
                    'is_profile_created' => $user->is_profile_created == 1  ? true : false,
                    'token' => $token
                ], 201);
            }



            if (!empty($user) && $user->gauth_id == null) {
                $user->gauth_id = $request->token;
                $user->save();


                $token =  $user->createToken('MyApp')->plainTextToken;

                return response()->json([
                    'status' => true,
                    'user_id' => $user->id,
                    'is_profile_created' => $user->is_profile_created == 1  ? true : false,
                    'token' => $token
                ], 201);
            }


            if (!empty($user->email) && !empty($user->gauth_id)) {

                if ($user->email == $request->email && $user->gauth_id == $request->token) {
                    $token =  $user->createToken('MyApp')->plainTextToken;

                    return response()->json([
                        'status' => true,
                        'user_id' => $user->id,
                        'is_profile_created' => $user->is_profile_created == 1  ? true : false,
                        'token' => $token
                    ], 201);
                }
            }


            return response()->json([
                'status' => false,
                'message' => 'Invalid User!'

            ], 401);
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





    public function loginWithFacebook(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required',
                    'token' => 'required',


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

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $user = User::create([

                    'email' => $request->email,
                    'user_type' => 'user',
                    'facebook_auth_id' => $request->token,
                    'socail_media_auth_type' => 'facebook'


                ]);

                $token =  $user->createToken('MyApp')->plainTextToken;

                return response()->json([
                    'status' => true,
                    'user_id' => $user->id,
                    'is_profile_created' => $user->is_profile_created == 1  ? true : false,
                    'token' => $token
                ], 201);
            }



            if (!empty($user) && $user->facebook_auth_id == null) {
                $user->facebook_auth_id = $request->token;
                $user->save();


                $token =  $user->createToken('MyApp')->plainTextToken;

                return response()->json([
                    'status' => true,
                    'user_id' => $user->id,
                    'is_profile_created' => $user->is_profile_created == 1  ? true : false,
                    'token' => $token
                ], 201);
            }


            if (!empty($user->email) && !empty($user->facebook_auth_id)) {

                if ($user->email == $request->email && $user->facebook_auth_id == $request->token) {
                    $token =  $user->createToken('MyApp')->plainTextToken;

                    return response()->json([
                        'status' => true,
                        'user_id' => $user->id,
                        'is_profile_created' => $user->is_profile_created == 1  ? true : false,
                        'token' => $token
                    ], 201);
                }
            }


            return response()->json([
                'status' => false,
                'message' => 'Invalid User!'

            ], 401);
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









    public function logout(Request $request)
    {
        try {

            $user = User::findOrFail($request->user_id);
            //Revoke the user's token
            $user->tokens()->delete();
            return response()->json([
                'status' => true,
                'message' => 'User Logout Successfully!',

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



    public function profile(Request $request)
    {
        try {

            $user = User::findOrFail($request->user_id);
            if(!empty($user->profile_img))
            {
                $profileImage = url(Storage::url($user->profile_img));
                
            }else
            {
                $profileImage = 'https://foreastro.com/assets/img/avatar-place.png';
            }
            
            $profile = [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->mobile_number,
                'gender' => $user->gender,
                'country' => 'India',
                'state' => $user->state,
                'city' => $user->city,
                'profile_img' => $profileImage,
                'is_profile_created' => $user->is_profile_created == 1 ? true : false,
                'status' => $user->status,
                'date_of_birth' => $user->date_of_birth,
                'birth_time' => $user->birth_time,
                'sign' => $user->sign,
                'wallet' => $user->wallet == null ? '0.00' : number_format($user->wallet, 2, '.', ''),
                'signal_id' => $user->signal_id,
                'created_at' => $user->created_at,
            ];


            return response()->json(
                [
                    'status' => true,
                    'data' => $profile
                ],
                201
            );
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

    public function profileUpdate(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',

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

            $user = User::findOrFail($request->user_id);

            $profileImage = $request->file('profile_image');
            if ($profileImage) {
                $uuid = Str::uuid()->toString();
                $extension = $request->file('profile_image')->extension();
                $fileName = $uuid . 'profile_image' . '.' . $extension;
                $documentPath = 'user';
                $filePath = $documentPath . '/' . $fileName;


                $storedFilePath = $profileImage->storeAs($documentPath, $fileName, 'public');
            } else {
                $filePath = $user->profile_img;
            }





            $user = User::where('id', $request->user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                //'mobile_number' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'profile_img' => $filePath,
                'birth_time' => $request->birth_time,
                'state' => $request->state,
                'city' => $request->city,
                'sign' => $request->sign,
                'gender' => $request->gender,
                'is_profile_created' => '1'

            ]);
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Profile update successfully!'
                ],
                201
            );
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




    public function banner(Request $request)
    {

        try {

            $banners = Banner::where('status', '1')->orderBy('id', 'desc')->get();


            $bannerListing = [];

            foreach ($banners as $banner) {
                $bannerListing[] =  url(Storage::url($banner->name['file']));
            }


            return response()->json(
                [
                    'status' => true,
                    'data' => $bannerListing
                ],
                201
            );
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


    public function blog(Request $request)
    {

        try {

            $blogs = Blog::where('status', '1')->orderBy('id', 'desc')->get();


            $blogListing = [];

            foreach ($blogs as $blog) {
                $blogListing[] =  [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'image' => url(Storage::url($blog->image['file']))

                ];
            }


            return response()->json(
                [
                    'status' => true,
                    'data' => $blogListing
                ],
                201
            );
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


    public function blogDetails(Request $request)
    {

        try {

            $blog = Blog::findOrFail($request->blog_id);
            $blog = [
                'id' => $blog->id,
                'title' => $blog->title,
                'description' => $blog->description,
                'image' => url(Storage::url($blog->image['file']))
            ];

            return response()->json(
                [
                    'status' => true,
                    'data' => $blog
                ],
                201
            );
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


    public function listAstrologer(Request $request)
    {

        try {


            $userId = Auth::id();
            
            
            $user = Auth::user();
            
          
                   
            
            
            

            $astrologers = Astrologer::orderBy('boost_expire_at', 'desc')->where('profile_status', 'approved')->get();

            $listAstrologer1 = [];
            $listAstrologer2 = [];
            $listAstrologer3 = [];

            foreach ($astrologers as $astrologer) {

                $imageFile = File::where(['type' => 'astro_profile_image', 'other_id' => $astrologer->id, 'status' => '1'])->first();
                if (!empty($imageFile)) {
                    $profileImage = url(Storage::url($imageFile->path));
                } else {
                    $profileImage = null;
                }

                $today = Carbon::today()->toDateString();
                
                $averageRating = Review::where('astrologer_id', $astrologer->id)->where('status',1)->avg('rating');

                $chatCoupon = AstrologerCoupon::where(['astrologer_id' => $astrologer->id, 'type' => 'chat'])->first();
                $audioCoupon = AstrologerCoupon::where(['astrologer_id' => $astrologer->id, 'type' => 'audio'])->first();
                $videoCoupon = AstrologerCoupon::where(['astrologer_id' => $astrologer->id, 'type' => 'video'])->first();

                //chat
                $chatCouponDiscount = Coupon::where('id', $chatCoupon->coupon_id ?? '')->whereDate('end_date', '>=', $today)->first();

                if (!empty($chatCouponDiscount)) {

                    if ($chatCouponDiscount->discount_type == 'percent') {
                        $chatAfterDiscountPrice = (string)($astrologer->chat_charges_per_min - ($astrologer->chat_charges_per_min * $chatCouponDiscount->discount / 100));
                    } else {
                        $chatAfterDiscountPrice = (string)($astrologer->chat_charges_per_min - $chatCouponDiscount->discount);
                    }

                    $callCouponCode = $chatCouponDiscount->code;
                    $callDiscountStatus = true;
                } else {
                    $chatAfterDiscountPrice = $astrologer->chat_charges_per_min;
                    $callCouponCode = null;
                    $callDiscountStatus = false;
                }


                //auido

                $auidoCouponDiscount = Coupon::where('id', $audioCoupon->coupon_id ?? '')->whereDate('end_date', '>=', $today)->first();

                if (!empty($auidoCouponDiscount)) {

                    if ($auidoCouponDiscount->discount_type == 'percent') {
                        $auidoAfterDiscountPrice = (string)($astrologer->call_charges_per_min - ($astrologer->call_charges_per_min * $auidoCouponDiscount->discount / 100));
                    } else {
                        $auidoAfterDiscountPrice = (string)($astrologer->call_charges_per_min - $auidoCouponDiscount->discount);
                    }

                    $audioCouponCode = $auidoCouponDiscount->code;
                    $auidoDiscountStatus = true;
                } else {
                    $auidoAfterDiscountPrice = $astrologer->call_charges_per_min;
                    $audioCouponCode = null;
                    $auidoDiscountStatus = false;
                }

                //video

                $videoCouponDiscount = Coupon::where('id', $videoCoupon->coupon_id ?? '')->whereDate('end_date', '>=', $today)->first();

                if (!empty($videoCouponDiscount)) {

                    if ($videoCouponDiscount->discount_type == 'percent') {
                        $videoAfterDiscountPrice = (string)($astrologer->video_charges_per_min - ($astrologer->video_charges_per_min * $videoCouponDiscount->discount / 100));
                    } else {
                        $videoAfterDiscountPrice = (string)($astrologer->video_charges_per_min - $videoCouponDiscount->discount);
                    }

                    $videoCouponCode = $videoCouponDiscount->code;
                    $videoDiscountStatus = true;
                } else {
                    $videoAfterDiscountPrice = $astrologer->video_charges_per_min;
                    $videoCouponCode = null;
                    $videoDiscountStatus = false;
                }




                $follow = Follower::where(['user_id' => $userId, 'astrologer_id' => $astrologer->id])->first();




                // print_r();die;


                if (empty($follow)) {
                    $statusFollow = '0';
                } else {
                    if ($follow->status == null) {
                        $statusFollow = '0';
                    } else {

                        $statusFollow = $follow->status;
                    }
                }


                $currentTime = Carbon::now();
                $timeToCompare = Carbon::parse($astrologer->expire_at);
                $timeToCompareBoost = Carbon::parse($astrologer->boost_expire_at);

                if (isset($astrologer->expire_at) && $timeToCompare->greaterThan($currentTime) && $astrologer->is_online == 'online') {


                    $astrologerOnlineStatus  = true;

                    if ($timeToCompareBoost->greaterThan($currentTime)) {
                        $listAstrologer1[] = [
                            'id' => $astrologer->id,
                            'name' => $astrologer->name,
                            'profile_img' => $profileImage,
                            'experience' => $astrologer->experience ?? 0,
                            'rating' => $averageRating ?? 0,
                            'languaage' => $astrologer->languaage,
                            'specialization' =>  $astrologer->specialization,

                            'before_chat_discount_price' => $astrologer->chat_charges_per_min ?? 0,
                            'chat_charges_per_min' =>  $chatAfterDiscountPrice ?? 0,
                            'chat_coupon_code' => $callCouponCode,
                            'chat_discount_status' => $callDiscountStatus,

                            'before_call_charges_per_min' =>  $astrologer->call_charges_per_min ?? 0,
                            'call_charges_per_min' =>  $auidoAfterDiscountPrice ?? 0,
                            'call_coupon_code' => $audioCouponCode,
                            'call_discount_status' => $auidoDiscountStatus,


                            'befor_video_charges_per_min' =>  $astrologer->video_charges_per_min ?? 0,
                            'video_charges_per_min' =>  $videoAfterDiscountPrice ?? 0,
                            'video_coupon_code' => $videoCouponCode,
                            'video_discount_status' => $videoDiscountStatus,
                            'is_online' => $astrologerOnlineStatus,
                            'follow_status' => $statusFollow,
                            'notifaction_token' => $astrologer->notifaction_token,
                            'signal_id' => $astrologer->signal_id

                        ];
                    } else {

                        $listAstrologer2[] = [
                            'id' => $astrologer->id,
                            'name' => $astrologer->name,
                            'profile_img' => $profileImage,
                            'experience' => $astrologer->experience ?? 0,
                            'rating' => $averageRating ?? 0,
                            'languaage' => $astrologer->languaage,
                            'specialization' =>  $astrologer->specialization,

                            'before_chat_discount_price' => $astrologer->chat_charges_per_min ?? 0,
                            'chat_charges_per_min' =>  $chatAfterDiscountPrice ?? 0,
                            'chat_coupon_code' => $callCouponCode,
                            'chat_discount_status' => $callDiscountStatus,


                            'before_call_charges_per_min' =>  $astrologer->call_charges_per_min ?? 0,
                            'call_charges_per_min' =>  $auidoAfterDiscountPrice ?? 0,
                            'call_coupon_code' => $audioCouponCode,
                            'call_discount_status' => $auidoDiscountStatus,


                            'befor_video_charges_per_min' =>  $astrologer->video_charges_per_min ?? 0,
                            'video_charges_per_min' =>  $videoAfterDiscountPrice ?? 0,
                            'video_coupon_code' => $videoCouponCode,
                            'video_discount_status' => $videoDiscountStatus,
                            'is_online' => $astrologerOnlineStatus,
                            'follow_status' => $statusFollow,
                            'notifaction_token' => $astrologer->notifaction_token,
                            'signal_id' => $astrologer->signal_id

                        ];
                    }


                    // online
                    //Astrologer online status Expired

                } else {
                    // offline
                    //Astrologer online status Expired
                    $astrologerOnlineStatus  = false;

                    $listAstrologer3[] = [
                        'id' => $astrologer->id,
                        'name' => $astrologer->name,
                        'profile_img' => $profileImage,
                        'experience' => $astrologer->experience ?? 0,
                        'rating' => $averageRating ?? 0,
                        'languaage' => $astrologer->languaage,
                        'specialization' =>  $astrologer->specialization,
                        'before_chat_discount_price' => $astrologer->chat_charges_per_min ?? 0,
                        'chat_charges_per_min' =>  $chatAfterDiscountPrice ?? 0,
                        'chat_coupon_code' => $callCouponCode,
                        'chat_discount_status' => $callDiscountStatus,


                        'before_call_charges_per_min' =>  $astrologer->call_charges_per_min ?? 0,
                        'call_charges_per_min' =>  $auidoAfterDiscountPrice ?? 0,
                        'call_coupon_code' => $audioCouponCode,
                        'call_discount_status' => $auidoDiscountStatus,


                        'befor_video_charges_per_min' =>  $astrologer->video_charges_per_min ?? 0,
                        'video_charges_per_min' =>  $videoAfterDiscountPrice ?? 0,
                        'video_coupon_code' => $videoCouponCode,
                        'video_discount_status' => $videoDiscountStatus,

                        'is_online' => $astrologerOnlineStatus,
                        'follow_status' => $statusFollow,
                        'notifaction_token' => $astrologer->notifaction_token,
                        'signal_id' => $astrologer->signal_id

                    ];
                }
            }

            $listAstrologers = array_merge($listAstrologer1, $listAstrologer2, $listAstrologer3);

            return response()->json(
                [
                    'status' => true,
                    'data' => $listAstrologers
                ],
                201
            );
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


    public function astrologerDetails(Request $request)
    {
        try {


            $astrologer = Astrologer::findOrFail($request->astro_id);

            $imageFile = File::where(['type' => 'astro_profile_image', 'other_id' => $astrologer->id, 'status' => '1'])->first();
            if (!empty($imageFile)) {
                $profileImage = url(Storage::url($imageFile->path));
            } else {
                $profileImage = null;
            }


            $today = Carbon::today()->toDateString();

            $chatCoupon = AstrologerCoupon::where(['astrologer_id' => $astrologer->id, 'type' => 'chat'])->first();
            $audioCoupon = AstrologerCoupon::where(['astrologer_id' => $astrologer->id, 'type' => 'audio'])->first();
            $videoCoupon = AstrologerCoupon::where(['astrologer_id' => $astrologer->id, 'type' => 'video'])->first();

            //chat
            $chatCouponDiscount = Coupon::where('id', $chatCoupon->coupon_id ?? '')->whereDate('end_date', '>=', $today)->first();

            if (!empty($chatCouponDiscount)) {

                if ($chatCouponDiscount->discount_type == 'percent') {
                    $chatAfterDiscountPrice = $astrologer->chat_charges_per_min - ($astrologer->chat_charges_per_min * $chatCouponDiscount->discount / 100);
                } else {
                    $chatAfterDiscountPrice = $astrologer->chat_charges_per_min - $chatCouponDiscount->discount;
                }

                $callCouponCode = $chatCouponDiscount->code;
                $callDiscountStatus = true;
            } else {
                $chatAfterDiscountPrice = $astrologer->chat_charges_per_min;
                $callCouponCode = null;
                $callDiscountStatus = false;
            }


            //auido

            $auidoCouponDiscount = Coupon::where('id', $audioCoupon->coupon_id ?? '')->whereDate('end_date', '>=', $today)->first();

            if (!empty($auidoCouponDiscount)) {

                if ($auidoCouponDiscount->discount_type == 'percent') {
                    $auidoAfterDiscountPrice = $astrologer->call_charges_per_min - ($astrologer->call_charges_per_min * $auidoCouponDiscount->discount / 100);
                } else {
                    $auidoAfterDiscountPrice = $astrologer->call_charges_per_min - $auidoCouponDiscount->discount;
                }

                $audioCouponCode = $auidoCouponDiscount->code;
                $auidoDiscountStatus = true;
            } else {
                $auidoAfterDiscountPrice = $astrologer->call_charges_per_min;
                $audioCouponCode = null;
                $auidoDiscountStatus = false;
            }

            //video

            $videoCouponDiscount = Coupon::where('id', $videoCoupon->coupon_id ?? '')->whereDate('end_date', '>=', $today)->first();

            if (!empty($videoCouponDiscount)) {

                if ($videoCouponDiscount->discount_type == 'percent') {
                    $videoAfterDiscountPrice = $astrologer->video_charges_per_min - ($astrologer->video_charges_per_min * $videoCouponDiscount->discount / 100);
                } else {
                    $videoAfterDiscountPrice = $astrologer->video_charges_per_min - $videoCouponDiscount->discount;
                }

                $videoCouponCode = $videoCouponDiscount->code;
                $videoDiscountStatus = true;
            } else {
                $videoAfterDiscountPrice = $astrologer->video_charges_per_min;
                $videoCouponCode = null;
                $videoDiscountStatus = false;
            }














            $currentTime = Carbon::now();
            $timeToCompare = Carbon::parse($astrologer->expire_at);


            if (isset($astrologer->expire_at) && $timeToCompare->greaterThan($currentTime) && $astrologer->is_online == 'online') {
                // online
                //Astrologer online status Expired

                $astrologerOnlineStatus  = true;
            } else {
                // offline
                //Astrologer online status Expired
                $astrologerOnlineStatus  = false;
            }



            $ratings = Review::where(['astrologer_id' => $request->astro_id, 'status' => '1'])->get();

            $ratingListing = [];

            foreach ($ratings as $rating) {


                $user = User::findOrFail($rating->user_id);




                $ratingListing[] = [

                    'user_name' => $user->name,
                    'user_img' => url(Storage::url($user->profile_img)),
                    'rating' => $rating->rating,
                    'comment' => $rating->comment,
                    'post_date' => $rating->created_at,

                ];
            }






            $astrologerDetails = [
                'id' => $astrologer->id,
                'id' => $astrologer->name,
                'profile_img' => $profileImage,
                'experience' => $astrologer->experience,
                'total_rating' => $astrologer->total_rating,
                'reviews' => $ratingListing,
                'languaage' => $astrologer->languaage,
                'description' => $astrologer->description,
                'specialization' =>  $astrologer->specialization,

                'before_chat_discount_price' => $astrologer->chat_charges_per_min,
                'chat_charges_per_min' =>  $chatAfterDiscountPrice,
                'chat_coupon_code' => $callCouponCode,
                'chat_discount_status' => $callDiscountStatus,


                'before_call_charges_per_min' =>  $astrologer->call_charges_per_min,
                'call_charges_per_min' =>  $auidoAfterDiscountPrice,
                'call_coupon_code' => $audioCouponCode,
                'call_discount_status' => $auidoDiscountStatus,


                'befor_video_charges_per_min' =>  $astrologer->video_charges_per_min,
                'video_charges_per_min' =>  $videoAfterDiscountPrice,
                'video_coupon_code' => $videoCouponCode,
                'video_discount_status' => $videoDiscountStatus,

                'is_online' => $astrologerOnlineStatus,
                'notifaction_token' => $astrologer->notifaction_token,
                'signal_id' => $astrologer->signal_id

            ];

            return response()->json(
                [
                    'status' => true,
                    'data' => $astrologerDetails
                ],
                201
            );
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

    public function onlineAstrologer(Request $request)
    {
        try {



            $astrologers = Astrologer::orderBy('boost_expire_at', 'desc')->where('profile_status', 'approved')->where('expire_at', '>', Carbon::now())->where('is_online', 'online')->get();







            $listAstrologer1 = [];
            $listAstrologer2 = [];

            foreach ($astrologers as $astrologer) {



                $imageFile = File::where(['type' => 'astro_profile_image', 'other_id' => $astrologer->id, 'status' => '1'])->first();
                if (!empty($imageFile)) {
                    $profileImage = url(Storage::url($imageFile->path));
                } else {
                    $profileImage = null;
                }

                $today = Carbon::today()->toDateString();

                $chatCoupon = AstrologerCoupon::where(['astrologer_id' => $astrologer->id, 'type' => 'chat'])->first();
                $audioCoupon = AstrologerCoupon::where(['astrologer_id' => $astrologer->id, 'type' => 'audio'])->first();
                $videoCoupon = AstrologerCoupon::where(['astrologer_id' => $astrologer->id, 'type' => 'video'])->first();

                //chat
                $chatCouponDiscount = Coupon::where('id', $chatCoupon->coupon_id ?? '')->whereDate('end_date', '>=', $today)->first();

                if (!empty($chatCouponDiscount)) {

                    if ($chatCouponDiscount->discount_type == 'percent') {
                        $chatAfterDiscountPrice = $astrologer->chat_charges_per_min - ($astrologer->chat_charges_per_min * $chatCouponDiscount->discount / 100);
                    } else {
                        $chatAfterDiscountPrice = $astrologer->chat_charges_per_min - $chatCouponDiscount->discount;
                    }

                    $callCouponCode = $chatCouponDiscount->code;
                    $callDiscountStatus = true;
                } else {
                    $chatAfterDiscountPrice = $astrologer->chat_charges_per_min;
                    $callCouponCode = null;
                    $callDiscountStatus = false;
                }


                //auido

                $auidoCouponDiscount = Coupon::where('id', $audioCoupon->coupon_id ?? '')->whereDate('end_date', '>=', $today)->first();

                if (!empty($auidoCouponDiscount)) {

                    if ($auidoCouponDiscount->discount_type == 'percent') {
                        $auidoAfterDiscountPrice = $astrologer->call_charges_per_min - ($astrologer->call_charges_per_min * $auidoCouponDiscount->discount / 100);
                    } else {
                        $auidoAfterDiscountPrice = $astrologer->call_charges_per_min - $auidoCouponDiscount->discount;
                    }

                    $audioCouponCode = $auidoCouponDiscount->code;
                    $auidoDiscountStatus = true;
                } else {
                    $auidoAfterDiscountPrice = $astrologer->call_charges_per_min;
                    $audioCouponCode = null;
                    $auidoDiscountStatus = false;
                }

                //video

                $videoCouponDiscount = Coupon::where('id', $videoCoupon->coupon_id ?? '')->whereDate('end_date', '>=', $today)->first();

                if (!empty($videoCouponDiscount)) {

                    if ($videoCouponDiscount->discount_type == 'percent') {
                        $videoAfterDiscountPrice = $astrologer->video_charges_per_min - ($astrologer->video_charges_per_min * $videoCouponDiscount->discount / 100);
                    } else {
                        $videoAfterDiscountPrice = $astrologer->video_charges_per_min - $videoCouponDiscount->discount;
                    }

                    $videoCouponCode = $videoCouponDiscount->code;
                    $videoDiscountStatus = true;
                } else {
                    $videoAfterDiscountPrice = $astrologer->video_charges_per_min;
                    $videoCouponCode = null;
                    $videoDiscountStatus = false;
                }


                if (isset($astrologer->expire_at) && now()->greaterThan($astrologer->expire_at)) {
                    // Expired
                    //Astrologer online status Expired

                    $astrologerOnlineStatus  = false;
                } else {
                    // Not expired
                    //Astrologer online status Expired

                    $astrologerOnlineStatus  = true;
                }


                $currentTime = Carbon::now();

                $timeToCompareBoost = Carbon::parse($astrologer->boost_expire_at);



                if ($timeToCompareBoost->greaterThan($currentTime)) {
                    $listAstrologer1[] = [
                        'id' => $astrologer->id,
                        'name' => $astrologer->name,
                        'profile_img' => $profileImage,
                        'experience' => $astrologer->experience,
                        'rating' => '0.0',
                        'languaage' => $astrologer->languaage,
                        'specialization' =>  $astrologer->specialization,

                        'before_chat_discount_price' => $astrologer->chat_charges_per_min,
                        'chat_charges_per_min' =>  $chatAfterDiscountPrice,
                        'chat_coupon_code' => $callCouponCode,
                        'chat_discount_status' => $callDiscountStatus,


                        'before_call_charges_per_min' =>  $astrologer->call_charges_per_min,
                        'call_charges_per_min' =>  $auidoAfterDiscountPrice,
                        'call_coupon_code' => $audioCouponCode,
                        'call_discount_status' => $auidoDiscountStatus,


                        'befor_video_charges_per_min' =>  $astrologer->video_charges_per_min,
                        'video_charges_per_min' =>  $videoAfterDiscountPrice,
                        'video_coupon_code' => $videoCouponCode,
                        'video_discount_status' => $videoDiscountStatus,

                        'is_online' => $astrologerOnlineStatus,
                        'signal_id' => $astrologer->signal_id

                    ];
                } else {

                    $listAstrologer2[] = [
                        'id' => $astrologer->id,
                        'name' => $astrologer->name,
                        'profile_img' => $profileImage,
                        'experience' => $astrologer->experience,
                        'rating' => '0.0',
                        'languaage' => $astrologer->languaage,
                        'specialization' =>  $astrologer->specialization,

                        'before_chat_discount_price' => $astrologer->chat_charges_per_min,
                        'chat_charges_per_min' =>  $chatAfterDiscountPrice,
                        'chat_coupon_code' => $callCouponCode,
                        'chat_discount_status' => $callDiscountStatus,


                        'before_call_charges_per_min' =>  $astrologer->call_charges_per_min,
                        'call_charges_per_min' =>  $auidoAfterDiscountPrice,
                        'call_coupon_code' => $audioCouponCode,
                        'call_discount_status' => $auidoDiscountStatus,


                        'befor_video_charges_per_min' =>  $astrologer->video_charges_per_min,
                        'video_charges_per_min' =>  $videoAfterDiscountPrice,
                        'video_coupon_code' => $videoCouponCode,
                        'video_discount_status' => $videoDiscountStatus,

                        'is_online' => $astrologerOnlineStatus,
                        'signal_id' => $astrologer->signal_id

                    ];
                }
            }

            $listAstrologers = array_merge($listAstrologer1, $listAstrologer2);

            return response()->json(
                [
                    'status' => true,
                    'data' => $listAstrologers
                ],
                201
            );
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



    public function givReview(Request $request)
    {
        try {


            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    'astrologer_id' => 'required',
                    'rating' => 'required',

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



            $review = Review::where(['user_id' => $request->user_id, 'astrologer_id' => $request->astrologer_id])->first();

            if (!empty($review)) {
                return response()->json([
                    'status' => false,
                    'error' => [
                        'code' => 401,
                        'message' => 'You have reviewed this profile.',
                    ],
                    'data' => $validator->errors()
                ], 401);
            }

            Review::create([
                'user_id' => $request->user_id,
                'astrologer_id' => $request->astrologer_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'status' => '1',

            ]);

            $sumRating  =  Review::where(['astrologer_id' => $request->astrologer_id, 'status' => '1'])->sum('rating');
            $avg = ($sumRating / 5);


            $astrologer = Astrologer::findOrFail($request->astrologer_id);
            $astrologer->total_rating = $avg;
            $astrologer->save();


            return response()->json(
                [
                    'status' => true,
                    'message' => 'Review saved successfully!'
                ],
                201
            );
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

    public function contact(Request $request)
    {

        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required',
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


            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'type' => $request->type,
                'descreption' => $request->descreption,
            ]);


            return response()->json(
                [
                    'status' => true,
                    'message' => 'Record saved successfully!'
                ],
                201
            );
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



    public function follow(Request $request)
    {

        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    'astro_id' => 'required',


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


            $follower = Follower::where(['user_id' => $request->user_id, 'astrologer_id' => $request->astro_id])->first();

            if (isset($follower) && $follower->status == '1') {
                return response()->json([
                    'status' => false,
                    'error' => [
                        'code' => 401,
                        'message' => 'You have already followed!',
                    ],
                    'data' => $validator->errors()
                ], 401);
            }


            if (!empty($follower)) {
                $follower->status = '1';
                $follower->save();
            } else {

                Follower::create([
                    'user_id' => $request->user_id,
                    'astrologer_id' => $request->astro_id,
                    'status' => '1',
                ]);
            }


            return response()->json(
                [
                    'status' => true,
                    'message' => 'Follow successfully!'
                ],
                201
            );
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

    public function myFollowing(Request $request)
    {

        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
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


            $followings = Follower::where(['user_id' => $request->user_id, 'status' => '1'])->with('astrologer')->get();

    
            
            
            $listMyFollowing = [];
            foreach ($followings as $following) {
                 $imageFile = File::where(['type' => 'astro_profile_image', 'other_id' =>$following->astrologer->id, 'status' => '1'])->first();
              if (!empty($imageFile)) {
                $profileImage = url(Storage::url($imageFile->path));
            } else {
                $profileImage = 'https://foreastro.com/assets/frontend/img/logo.png';
            }
                $listMyFollowing[] = [
                    'id' => $following->id,
                    'astrologier_id' => $following->astrologer_id,
                    'user_id' => $following->user_id,
                    'astrologier_name' => $following->astrologer->name,
                    'rating' => $following->astrologer->rating,
                    'experience' => $following->astrologer->experience,
                    'profile_img' => $profileImage,
                    'languaage' => $following->astrologer->languaage,
                    'specialization' => $following->astrologer->specialization

                ];
            }

            return response()->json(
                [
                    'status' => true,
                    'data' => $listMyFollowing
                ],
                201
            );
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



    public function sendUserNotifactionToken(Request $request)
    {


        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    'notifaction_token' => 'required',
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



            $user = User::findOrFail($request->user_id);

            $user->notifaction_token = $request->notifaction_token;
            $user->save();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'user notifacation tocken save!'
                ],
                201
            );
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


    public function createPayment(Request $request)
    {

        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    'name' => 'required',
                    'order_id' => 'required',
                    'payment_id' => 'required',
                    'amount' => 'required',
                    'date' => 'required',
                    'status' => 'required',

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


            //Payment

            $user = User::findOrFail($request->user_id);

            if ($request->status == 'paid') {

                if ($user->wallet != null) {
                    $user->wallet = $user->wallet + $request->amount;
                } else {
                    $user->wallet = $request->amount;
                }
                $user->save();
            }
            $payment = Payment::create([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'order_id' => $request->order_id,
                'payment_id' => $request->payment_id,
                'amount' => $request->amount,
                'date' => $request->date,
                'status' => $request->status,
            ]);

            if ($payment->status == 'paid') {

                $message = 'Payment successfully!';
            } else {

                $message = 'Payment Faild!';
            }

            return response()->json(
                [
                    'status' => true,
                    'message' => $message
                ],
                201
            );
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



    public function walletHistory(Request $request)
    {

        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
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


            $listPayment = [];

            $payments = Payment::where('user_id', $request->user_id)->orderBy('id', 'desc')->get();

            foreach ($payments as $payment) {
                $listPayment[] = [

                    'id' => $payment->id,
                    'name' => $payment->name,
                    'order_id' => $payment->order_id,
                    'payment_id' => $payment->payment_id,
                    'amount' => $payment->amount,
                    'date' => $payment->date,
                    'status' => $payment->status,
                ];
            }



            return response()->json(
                [
                    'status' => true,
                    'data' => $listPayment
                ],
                201
            );
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






    public function unfollow(Request $request)
    {

        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'follower_id' => 'required',
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


            $follower = Follower::findOrFail($request->follower_id);
            $follower->status = '0';
            $follower->save();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Un-Follow Successfully!'
                ],
                201
            );
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

    public function celebrity(Request $request)
    {
        try {

            $celebrities = Celebrity::orderBy('id', 'desc')->get();

            $celebrityList = [];
            foreach ($celebrities as $celebrity) {
                $celebrityList[] = [
                    'id' => $celebrity->id,
                    'title' => $celebrity->title,
                    'thumbnail' => url(Storage::url($celebrity->thumbnail)),
                    'video' => url(Storage::url($celebrity->video_path)),

                ];
            }

            return response()->json(
                [
                    'status' => true,
                    'data' => $celebrityList
                ],
                201
            );
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



    public function testimonial(Request $request)
    {

        try {

            $testimonials = Testimonial::orderBy('id', 'desc')->get();

            $testimonialList = [];

            foreach ($testimonials as $testimonial) {

                $testimonialList[] = [
                    'name' => $testimonial->name,
                    'image' => url(Storage::url($testimonial->image)),
                    'rating' => $testimonial->rating,
                    'comment' => $testimonial->descreption,
                ];
            }




            return response()->json(
                [
                    'status' => true,
                    'data' => $testimonialList
                ],
                201
            );
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

    public function communicationCharges(Request $request)
    {



        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'communication_id' => 'required',
                    'astro_per_min_price' => 'required',
                    'time' => 'required',
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

//log create

            Astrolog::create([
                'communication_id' => $request->communication_id,
                'type' =>'create',
                'descreption'=>'log create successfully',
                
                ]);



            list($hours, $minutes, $seconds) = explode(':', $request->time);

            $totalSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;


            //$communication = Communication::where(['communication_id' => $request->communication_id])->first();
            $communication = Communication::where(['communication_id' => $request->communication_id, 'status' => 'accept'])->first();
           

            if (empty($communication)) {
                return response()->json([
                    'status' => false,
                    'error' => [
                        'code' => 401,
                        'message' => 'Record not found!',
                    ],

                ], 401);
            }

            $astrologerData = Astrologer::findOrFail($communication->astrologer_id);
            if ($communication->type == 'chat') {
                $astroChargesPerMin =  $astrologerData->chat_charges_per_min;
            } else if ($communication->type == 'audio') {
                $astroChargesPerMin =  $astrologerData->call_charges_per_min;
            } else {
                $astroChargesPerMin =  $astrologerData->video_charges_per_min;
            }

            if (!empty($communication->coupon_applied) && $communication->coupon_applied != 'null') {

                $coupon = Coupon::where('code', $communication->coupon_applied)->first();

                if ($coupon->discount_type == 'percent') {
                    $couponDiscountAmountInMin = ($astroChargesPerMin * $coupon->discount) / 100;
                    $couponDiscountAmount = ($couponDiscountAmountInMin * 60) / $totalSeconds;
                } else {
                    $couponDiscountAmount = ($coupon->discount * 60) / $totalSeconds;
                }
            } else {
                $couponDiscountAmount = 0;
            }


            $perSecondPrice = $request->astro_per_min_price / 60;
            $totalChargeAmount = $perSecondPrice * $totalSeconds;
            $user = User::findOrFail($communication->user_id);
            $walletBalanceAmount = $user->wallet - $totalChargeAmount;
            $user->wallet = $walletBalanceAmount;
            $user->save();

            $communication->time = $totalSeconds;
            $communication->payment_status = 'pending';
            $communication->total_amount = number_format($totalChargeAmount, 2);
            $communication->astro_per_min_charge = $astroChargesPerMin;
            $communication->coupon_discount_amount = number_format($couponDiscountAmount, 2);
            $communication->save();
            
            
            
          

            return response()->json(
                [
                    'status' => true,
                    
                    'data' => 'Wallet amount deducted successfully!'
                ],
                201
            );
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
    
    
    
    
    
    public function communicationChargesUpdate(Request $request)
    {
        
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'communication_id' => 'required',
                    'time' => 'required',
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


 

            list($hours, $minutes, $seconds) = explode(':', $request->time);

            $totalSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;


            //$communication = Communication::where(['communication_id' => $request->communication_id])->first();
            $communication = Communication::where(['communication_id' => $request->communication_id, 'status' => 'accept'])->first();
           

            if (empty($communication)) {
                return response()->json([
                    'status' => false,
                    'error' => [
                        'code' => 401,
                        'message' => 'Record not found!',
                    ],

                ], 401);
            }
            
            
            
            if($communication->time==0)
            {
            //log create
             Astrolog::create([
                'communication_id' => $request->communication_id,
                'type' =>'update',
                'descreption'=>'log create update',
                
                ]);
            
            $astrologerData = Astrologer::findOrFail($communication->astrologer_id);
            if ($communication->type == 'chat') {
                $astroChargesPerMin =  $astrologerData->chat_charges_per_min;
            } else if ($communication->type == 'audio') {
                $astroChargesPerMin =  $astrologerData->call_charges_per_min;
            } else {
                $astroChargesPerMin =  $astrologerData->video_charges_per_min;
            }

            if (!empty($communication->coupon_applied) && $communication->coupon_applied != 'null') {

                $coupon = Coupon::where('code', $communication->coupon_applied)->first();

                if ($coupon->discount_type == 'percent') {
                    $couponDiscountAmountInMin = ($astroChargesPerMin * $coupon->discount) / 100;
                    $couponDiscountAmount = ($couponDiscountAmountInMin * 60) / $totalSeconds;
                } else {
                    $couponDiscountAmountInMin=$coupon->discount;
                    $couponDiscountAmount = ($coupon->discount * 60) / $totalSeconds;
                }
            } else {
                $couponDiscountAmountInMin = 0;
                $couponDiscountAmount = 0;
            }


            $perSecondPrice = ($astroChargesPerMin-$couponDiscountAmountInMin) / 60;
            $totalChargeAmount = $perSecondPrice * $totalSeconds;
            $user = User::findOrFail($communication->user_id);
            $walletBalanceAmount = $user->wallet - $totalChargeAmount;
            $user->wallet = $walletBalanceAmount;
            $user->save();

            $communication->time = $totalSeconds;
            $communication->payment_status = 'pending';
            $communication->total_amount = number_format($totalChargeAmount, 2);
            $communication->astro_per_min_charge = $astroChargesPerMin;
            $communication->coupon_discount_amount = number_format($couponDiscountAmount, 2);
            $communication->save();

            return response()->json(
                [
                    'status' => true,
                    
                    'data' => 'Wallet amount deducted successfully!'
                ],
                201
            );
            
            
            }else
            {
                
                 return response()->json(
                [
                    'status' => true,
                    
                    'data' => 'Wallet amount already deducted successfully!'
                ],
                201
            );
                
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
    
    
    
    
    public function userChatLog(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
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


            $chatLogs = Communication::orderBy('id', 'desc')->where(['user_id' => $request->user_id, 'type' => 'chat'])->with('astrologer')->get();


            $listChatLogs = [];

            foreach ($chatLogs as $chatLog) {
                
                
                 $imageFile = File::where(['type' => 'astro_profile_image', 'other_id' => $chatLog->astrologer->id, 'status' => '1'])->first();
                      if (!empty($imageFile)) {
                        $profileImage = url(Storage::url($imageFile->path));
                    } else {
                        $profileImage = 'https://foreastro.com/assets/frontend/img/logo.png';
                    }
                
    
               // print_r($chatLog->astrologer->name);die;
                $time = date("h:i A", strtotime($chatLog->created_at));
                $date = date("d/m/Y", strtotime($chatLog->created_at));
                $communicitionTime = $chatLog->time / 60;
                $listChatLogs[] = [
                    'id' => $chatLog->id,
                    'astro_id' => $chatLog->astrologer->id,
                    'name' => $chatLog->astrologer->name,
                    'profile_pic' => $profileImage,
                    'date' => $date,
                    'time' => $time,
                    'status' => $chatLog->status,
                    'type' => $chatLog->type,
                    'communicition_time' => number_format($communicitionTime, 2),
                    'total_amount' => $chatLog->total_amount
                ];
            }

            return response()->json(
                [
                    'status' => true,
                    'data' => $listChatLogs
                ],
                201
            );
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




    public function userCallLog(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
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

            $callLogs = Communication::orderBy('id', 'desc')->where('user_id', $request->user_id)
                ->where('type', '!=', 'chat')
                ->with('astrologer')
                ->get();
            $listCallLogs = [];

            foreach ($callLogs as $callLog) {
                $time = date("h:i A", strtotime($callLog->created_at));
                $date = date("d/m/Y", strtotime($callLog->created_at));

                $callTime = $callLog->time;

                $minutes = floor($callTime / 60);
                $seconds = $callTime % 60;


      $imageFile = File::where(['type' => 'astro_profile_image', 'other_id' => $callLog->astrologer->id, 'status' => '1'])->first();
              if (!empty($imageFile)) {
                $profileImage = url(Storage::url($imageFile->path));
            } else {
                $profileImage = 'https://foreastro.com/assets/frontend/img/logo.png';
            }



                $listCallLogs[] = [
                    'id' => $callLog->id,
                    'astro_id' => $callLog->astrologer->id,
                    'name' => $callLog->astrologer->name,
                    'profile_pic' => $profileImage,
                    'date' => $date,
                    'time' => $time,
                    'communication_id' => $callLog->communication_id,
                    'status' => $callLog->status,
                    'type' => $callLog->type,
                    'call_duration' => $minutes . ':' . $seconds,
                    'total_amount' => $callLog->total_amount
                ];
            }

            return response()->json(
                [
                    'status' => true,
                    'data' => $listCallLogs
                ],
                201
            );
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



    public function filterPendinUser(Request $request)
    {

        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
                    'user_name' => 'required',

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


            $userIds = User::where('name', 'like', '%' . $request->user_name . '%')->pluck('id')->toArray();


            $communications =  Communication::whereIn('user_id', $userIds)->where(['astrologer_id' => $request->astro_id, 'status' => 'pending', 'type' => 'chat'])->with('user')->get();

            $listChatRequest = [];
            foreach ($communications as $communication) {
                $time = date("h:i A", strtotime($communication->created_at));
                $date = date("d/m/Y", strtotime($communication->created_at));
                $listChatRequest[] = [
                    'id' => $communication->id,
                    'user_id' => $communication->user->id,
                    'name' => $communication->user->name,
                    'profile_pic' => url(Storage::url($communication->user->profile_img)),
                    'date' => $date,
                    'time' => $time,
                    'communication_id' => $communication->communication_id,
                    'status' => $communication->status,
                    'type' => $communication->type,
                ];
            }


            //call


            $callCommunications =  Communication::whereIn('user_id', $userIds)->where(['astrologer_id' => $request->astro_id, 'status' => 'pending', 'type' => 'call'])->with('user')->get();

            $listCallRequest = [];
            foreach ($callCommunications as $communication) {
                $time = date("h:i A", strtotime($communication->created_at));
                $date = date("d/m/Y", strtotime($communication->created_at));
                $listCallRequest[] = [
                    'id' => $communication->id,
                    'user_id' => $communication->user->id,
                    'name' => $communication->user->name,
                    'profile_pic' => url(Storage::url($communication->user->profile_img)),
                    'date' => $date,
                    'time' => $time,
                    'communication_id' => $communication->communication_id,
                    'status' => $communication->status,
                    'type' => $communication->type,
                ];
            }



            return response()->json(
                [
                    'status' => true,
                    'data' => [
                        'chat' => $listChatRequest,
                        'call' => $listCallRequest
                    ],

                ],
                201
            );
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


    public function listRamedy(Request $request)
    {

        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
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


            $astrologerIds  = Communication::where(['user_id' => $request->user_id, 'status' => 'accept'])->pluck('astrologer_id')->toArray();

            if (empty($astrologerIds)) {
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Ramedy Not Found!'
                    ],
                    404
                );
            }
            $ramedies = Ramedy::whereIn('astrologer_id', $astrologerIds)->get();
            $listRamedy = [];
            foreach ($ramedies as $ramedy) {

                $astrologer = Astrologer::where('id', $ramedy->astrologer_id)->first();
                
                 $imageFile = File::where(['type' => 'astro_profile_image', 'other_id' => $astrologer->id, 'status' => '1'])->first();
              if (!empty($imageFile)) {
                $profileImage = url(Storage::url($imageFile->path));
            } else {
                $profileImage = 'https://foreastro.com/assets/frontend/img/logo.png';
            }
                $listRamedy[] = [
                    'id' => $ramedy->id,
                    'astro_id' => $astrologer->id,
                    'astrologer_name' => $astrologer->name,
                    'astro_img' => $profileImage,
                    'description' => $ramedy->description

                ];
            }


            return response()->json(
                [
                    'status' => true,
                    'data' => $listRamedy

                ],
                200
            );
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
    
     public function listUser(Request $request)
    {

        try {
            $users = User::where('is_profile_created', '1')->whereNot('user_type', 'admin')->orderBy('name', 'asc')->get();

            $listUser = [];
            foreach ($users as $user) {
                $listUser[] = [
                    'id' => $user->id,
                    'user_name' => $user->name,
                    'profile_img' => url(Storage::url($user->profile_img)),
                    'notification_token' => $user->notifaction_token,
                    'signal_id' => $user->signal_id
                ];
            }
            return response()->json(
                [
                    'status' => true,
                    'data' => $listUser

                ],
                200
            );
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
    
    
    
    
    public function signalNotifaction(Request $request)
    {
        
       try{
             $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    'signal_id' => 'required',
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
            
           $user = User::findOrFail($request->user_id);
           $user->signal_id = $request->signal_id;
           $user->save();
           
            return response()->json(
                [
                    'status' => true,
                    'message' => 'notifacton id save'

                ],
                200
            );
           
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
       
       public function userPendingRequest(Request $request)
       {
           try{
               $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    
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
            
            $communicatiinRequests = Communication::where(['user_id' => $request->user_id, 'status' => 'pending'])->orderBy('id','desc')->get();
            
            
            
            $userRequests = [];
            foreach($communicatiinRequests as $communicatiinRequest)
            {
                
                $imageFile = File::where(['type' => 'astro_profile_image', 'other_id' => $communicatiinRequest->astrologer->id, 'status' => '1'])->first();
                if (!empty($imageFile)) {
                    $profileImage = url(Storage::url($imageFile->path));
                } else {
                    $profileImage = null;
                }
                
                $userRequests[]=[
                    'id' => $communicatiinRequest->id,
                    'astro_name' => $communicatiinRequest->astrologer->name ?? '',
                    'astro_profile_image' => $profileImage,
                    ];
            }
            
             return response()->json(
                [
                    'status' => true,
                    'data' => $userRequests

                ],
                200
            );
               
           }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => [
                    'code' => 500,
                    'message' =>  $th->getMessage(),
                ]
            ], 500);
        }
       }
       
       

       public function userPendingRequestCancel(Request $request)
       {
           try{
               $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required',
                    
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
            
            Communication::where('id', $request->id)->update([
                'status' => 'cancel'
                ]);
                
        return response()->json(
                [
                    'status' => true,
                    'message' => 'Request has  been cancled'

                ],
                200
            );
            
            }
            

           catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => [
                    'code' => 500,
                    'message' =>  $th->getMessage(),
                ]
            ], 500);
        }
           
           
       }
       
       
       
       
           //user version update
       
       
    public function versionUpdate(Request $request)
    {
        
       try{
             $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    'version' => 'required',
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
            
           $astrologer = User::findOrFail($request->user_id);
           $astrologer->version = $request->version;
           $astrologer->save();
           
            return response()->json(
                [
                    'status' => true,
                    'message' => 'version update successfully!'

                ],
                200
            );
           
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
       
       
       
       
       
       
    //   public function dataMigration()
    //   {
    //       //print_r('erewr');die;
    //       $communications = Communication::get();
           
           
    //       foreach($communications as $communication)
    //       {
    //           $astro = User::where('id', $communication->user_id)->first();
               
    //           if(empty($astro))
    //           {
    //               Communication::where('user_id', $communication->user_id)->delete();
    //               //Payout::where('astrologer_id', $communication->astrologer_id)->delete();
    //           }
               
               
               
    //       }
           
           
    //       print_r('ok');
           
           
    //   }
        
        
    
}
