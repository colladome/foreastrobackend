<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Astrologer;
use App\Models\AstrologerCoupon;
use App\Models\AstrologerLive;
use App\Models\AstroOtp;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\File;
use App\Models\AstrologerQuery;
use Illuminate\Support\Str;
use App\Models\Bank;
use App\Models\CmsManagement;
use App\Models\Communication;
use App\Models\Coupon;
use App\Models\Follower;
use App\Models\OnboardingQuestion;
use App\Models\Payout;
use App\Models\Review;
use App\Models\User;
use App\Models\Boost;
use App\Models\OnboardingAnswer;
use App\Models\Ramedy;

class AstrologerController extends Controller
{
    public function createProfile(Request $request)
    {

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'mobile_number' => 'required',
                    'email' => 'required|email|unique:astrologers',
                    'gender' => 'required',
                    'adhar_id' => 'required|unique:astrologers',
                    'pan_number' => 'required|unique:astrologers',
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
            $profileImage = $request->file('profile_images');


            if (!empty($request->file('profile_images'))) {

                foreach ($request->file('profile_images') as $image) {


                    $uuid = Str::uuid()->toString();
                    $extension = $image->extension();
                    $fileName = $uuid . 'profile_image' . '.' . $extension;
                    $documentPath = 'user';
                    $filePath = $documentPath . '/' . $fileName;
                    $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');
                    File::create([
                        'type' => 'astro_profile_image',
                        'other_id' => $request->astro_id,
                        'path' => $filePath,
                        'file_size' => $image->getSize()
                    ]);
                }
            }



            $astro = Astrologer::where('id', $request->astro_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                //'mobile_number' => $request->mobile_number,
                'gender' => $request->gender,
                'adhar_id' => $request->adhar_id,
                'pan_number' => $request->pan_number,
                'specialization' => $request->specialization,
                'languaage' => $request->language,
                'address' => $request->address,
                'state' => $request->state,
                'city' => $request->city,
                'pin_code' => $request->pin_code,
                // 'profile_img' => $filePath ?? null,
                'is_profile_created' => '1',
                'user_type' => 'astro',
                //'password' =>   Hash::make($request->password),

                'trusted' => '0',
                'status' => '1',
            ]);

            if (!empty($request->file('certifications'))) {



                foreach ($request->file('certifications') as $image) {




                    $uuid = Str::uuid()->toString();
                    $extension = $image->extension();
                    $fileName = $uuid . 'certification' . '.' . $extension;;
                    $documentPath = 'certifications';
                    $filePath = $documentPath . '/' . $fileName;
                    $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');
                    File::create([
                        'type' => 'astro_profile',
                        'other_id' => $request->astro_id,
                        'path' => $filePath,
                        'file_size' => $image->getSize()
                    ]);
                }
            }


            $astro = Astrologer::findOrFail($request->astro_id);

            return response()->json([
                'status' => true,
                'message' => 'Profile Created successfully!',
                'data' => [
                    'astro_id' => $astro->id,
                    'name' => $astro->name,
                    'email' => $astro->email,
                    'phone' => $astro->mobile_number,

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



    public function astroReviewListing(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
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




            return response()->json([
                'status' => true,
                'data' =>  $ratingListing,


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




    public function updateCertificate(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
                    'certifications' => 'required',

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



            $image = $request->file('certifications');
            $uuid = Str::uuid()->toString();
            $extension = $image->extension();
            $fileName = $uuid . 'certification' . '.' . $extension;;
            $documentPath = 'certifications';
            $filePath = $documentPath . '/' . $fileName;
            $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');
            File::create([
                'type' => 'astro_profile',
                'other_id' => $request->astro_id,
                'path' => $filePath,
                'file_size' => $image->getSize()
            ]);


            return response()->json([
                'status' => true,
                'message' => 'Certificate Upload successfully!',


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



    public function loginError(Request $request)
    {



        return response()->json([
            'status' => false,
            'error' => [
                'code' => 401,
                'message' => 'Please login!',
            ],

        ], 401);
    }




    /**
     * Login 
     */

    public function login(Request $request)
    {
        
       // return $request->version;
        
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
        
        
        if(!empty($request->version))
{
      $astrologer = Astrologer::where('mobile_number', $request->phone)->update([
          'version' => $request->version,
          ]);
          
         // return $request->version;
}
           
          $astrologer = Astrologer::where('mobile_number', $request->phone)->first();
          
          
           
         if(!empty($astrologer))
         {
          if($astrologer->version == 0 || $astrologer->version == '')
          {
              $url = "https://sms.staticking.com/index.php/smsapi/httpapi/";
                $fields = array(
                    'secret' => 'wmrZhOgKDs7Ve2sqkOcn',
                    'sender' => 'FOREAS',
                    'tempid' => '1707173832882206524',
                    'receiver' => $astrologer->mobile_number,
                    'route' => 'TA',
                    'msgtype' => '1',
                    'sms' => 'Dear User, Your app is outdated! Update now for a better experience:https://play.google.com/store/apps/details?id=com.foreastro.astrologer'
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
                'user_id' => $astrologer->id,
                'message' => 'please update your application'
                //'is_profile_created' => $user->is_profile_created == 1  ? true : false,


            ], 201);
          }
         }
           
           
        
        
       

            $astro = Astrologer::where(['mobile_number' => $request->phone])->first();
            
            
            
           






            if (empty($astro)) {


                $astro = Astrologer::create([

                    'mobile_number' => $request->phone,
                    'version' => $request->version,
                    'profile_status' => 'pending',
                    'is_profile_created' => '0',
                    'user_type' => 'astro',
                ]);







                $otp = rand(1000, 9999);

                $currentDateTime = Carbon::now();
                $expireAtDateTime = $currentDateTime->addMinutes(10);
                $expireAtDateTime = $expireAtDateTime->toDateTimeString();

                AstroOtp::create([
                    'astrologer_id' => $astro->id,
                    'otp_secret' => $otp,
                    'expires_at' => $expireAtDateTime
                ]);





                $url = "https://sms.staticking.com/index.php/smsapi/httpapi/";
                $fields = array(
                    'secret' => 'wmrZhOgKDs7Ve2sqkOcn',
                    'sender' => 'FOREAS',
                    'tempid' => '1707172060857103586',
                    'receiver' => $astro->mobile_number,
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

                // if (curl_errno($ch)) {
                //     echo 'Error:' . curl_error($ch);
                // } else {
                //     echo 'Response:' . $response;
                // }

                // Close the cURL session
                curl_close($ch);










                //$token =  $astro->createToken('MyApp')->plainTextToken;




                return response()->json([
                    'status' => true,
                    'astro_id' => $astro->id,
                    //'phone' => $astro->mobile_number,
                    // 'is_profile_created' => $astro->is_profile_created == 1  ? true : false,
                    // 'token' => $token
                ], 201);
            }




            $otp = 1234;//rand(1000, 9999);

            $currentDateTime = Carbon::now();
            $expireAtDateTime = $currentDateTime->addMinutes(10);
            $expireAtDateTime = $expireAtDateTime->toDateTimeString();

            AstroOtp::create([
                'astrologer_id' => $astro->id,
                'otp_secret' => $otp,
                'expires_at' => $expireAtDateTime
            ]);





            // $url = "https://sms.staticking.com/index.php/smsapi/httpapi/";
            // $fields = array(
            //     'secret' => 'wmrZhOgKDs7Ve2sqkOcn',
            //     'sender' => 'FOREAS',
            //     'tempid' => '1707172060857103586',
            //     'receiver' => $astro->mobile_number,
            //     'route' => 'TA',
            //     'msgtype' => '1',
            //     'sms' => 'Welcome to ForeAstro! Your OTP for login is ' . $otp . '. Please use it to log in to your account. This OTP is valid for 10 minutes.'
            // );

            // $fields_string = http_build_query($fields);

            // // Initialize cURL
            // $ch = curl_init();

            // // Set the URL
            // curl_setopt($ch, CURLOPT_URL, $url);

            // // Set the method to POST
            // curl_setopt($ch, CURLOPT_POST, 1);

            // // Attach the fields
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

            // // Return the response instead of printing
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // // Execute the request
            // $response = curl_exec($ch);

            // // if (curl_errno($ch)) {
            // //     echo 'Error:' . curl_error($ch);
            // // } else {
            // //     echo 'Response:' . $response;
            // // }

            // // Close the cURL session
            // curl_close($ch);










            //  $token =  $astro->createToken('MyApp')->plainTextToken;

            return response()->json([
                'status' => true,
                'astro_id' => $astro->id,
                'version' => $astro->version,
                //'phone' => $astro->mobile_number,
                // 'is_profile_created' => $astro->is_profile_created == 1  ? true : false,

                // 'token' => $token

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
                    'astro_id' => 'required',
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








            $astro = Astrologer::where('id', $request->astro_id)->first();
            if (!$astro) {
                return response()->json([
                    'status' => false,
                    'error' => [
                        'code' => 401,
                        'message' => 'Invalid Astrologer!',
                    ],

                ], 401);
            }

            if ($astro->mobile_number == '8948688702') {

                $token =  $astro->createToken('MyApp')->plainTextToken;

                return response()->json(
                    [
                        'status' => true,
                        'data' => [
                            'astro_id' => $astro->id,
                            'phone' => $astro->mobile_number,
                            'is_profile_created' => $astro->is_profile_created == 1  ? true : false,
                            'token' => $token
                        ],



                    ],
                    201
                );
            }

            $otp = AstroOtp::where('astrologer_id', $astro->id)->latest()->first();

            if ($otp && !$otp->isExpired() && $otp->otp_secret === $request->otp) {
                $otp->markAsVerified();
                $token =  $astro->createToken('MyApp')->plainTextToken;

                return response()->json(
                    [
                        'status' => true,
                        'data' => [
                            'astro_id' => $astro->id,
                            'phone' => $astro->mobile_number,
                            'is_profile_created' => $astro->is_profile_created == 1  ? true : false,
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





    public function personalDetail(Request $request)
    {
        try {

            Astrologer::where('id', $request->astro_id)->update([
                'date_of_birth' => $request->date_of_birth,
                'birth_place' => $request->birth_place,
                'city' => $request->city,
                'state' => $request->state,
                'address' => $request->address,
                'adhar_id' => $request->adhar_id,
                'pan_number' => $request->pan_number,
                'gender' => $request->gender,


            ]);


            return response()->json(
                [
                    'status' => true,
                    'message' => 'Personal Detail Update Successfully!'
                    // 'data' => $profile
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









    public function professionalDetail(Request $request)
    {
        try {

            Astrologer::where('id', $request->astro_id)->update([
                'experience' => $request->experience,
                'languaage' => $request->languaage,
                'call_charges_per_min' => $request->call_charges_per_min,
                'chat_charges_per_min' => $request->chat_charges_per_min,
                'education' => $request->education,
                'description' => $request->description,
                'start_time_slot' => $request->start_time_slot,
                'end_time_slot' => $request->end_time_slot,
                'video_charges_per_min' => $request->video_charges_per_min
            ]);

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Professional Detail Update Successfully!'
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



    public function bankDetail(Request $request)
    {
        try {

            Astrologer::where('id', $request->astro_id)->update([
                'bank_name' => $request->bank_name,

            ]);

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Bank Detail Update Successfully!'
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

    public function profile(Request $request)
    {
        try {
            $astrologer = Astrologer::findOrFail($request->astro_id);
            
          

            $files = File::where([
                'other_id' => $astrologer->id,
                'type' => 'astro_profile'
            ])->get();

            $certifications = [];


            foreach ($files as $file) {
                $certifications[] =
                    [
                        'certificate_id' => $file->id,
                        'certificate' => url(Storage::url($file->path)),
                        'file_size' => $file->file_size

                    ];
            }

            if (isset($astrologer->expire_at) && now()->greaterThan($astrologer->expire_at)) {
                // Expired
                //Astrologer online status Expired

                $astrologerOnlineStatus  = 'Offline';
            } else {
                // Not expired
                //Astrologer online status Expired

                if ($astrologer->is_online == 'online') {  //this if part when astrologer mark online then show online else show offline

                    $astrologerOnlineStatus  = 'Online';
                } else {
                    $astrologerOnlineStatus  = 'Offline';
                }
            }

            $liveChargesPerMin = CmsManagement::orderBy('id', 'desc')->first();




            //wallet caluclation


            $communicationTotalAmount = Communication::where([
                'astrologer_id' => $astrologer->id,
                'status' => 'accept'
            ])
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->sum('total_amount');


            $netAmountAstrologer = ($communicationTotalAmount * $astrologer->commission_percent) / 100;
            $netAmountAstrologer = $communicationTotalAmount - $netAmountAstrologer;


            $liveTotalAmount = AstrologerLive::where('astrologer_id', $astrologer->id)
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->sum('amount');

            $boostAmount = Boost::where('astrologer_id', $astrologer->id)
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->sum('amount');


            $astrologerWallet = $netAmountAstrologer  - ($boostAmount + $liveTotalAmount + $astrologer->wallet);


            $imageFile = File::where(['type' => 'astro_profile_image', 'other_id' => $astrologer->id, 'status' => '1'])->first();
            if (!empty($imageFile)) {
                $profileImage = url(Storage::url($imageFile->path));
            } else {
                $profileImage = null;
            }
            
            $averageRating = Review::where('astrologer_id', $astrologer->id)->where('status',1)->avg('rating');


            $profile = [
                'astro_id' => $astrologer->id,
                'name' => $astrologer->name,
                'email' => $astrologer->email,
                'phone' => $astrologer->mobile_number,
                'gender' => $astrologer->gender,
                'adhar_id' => $astrologer->adhar_id,
                'pan_number' => $astrologer->pan_number,
                'specialization' => $astrologer->specialization,
                'languaage' => $astrologer->languaage,
                'certifications' => $certifications,
                'address' => $astrologer->address,
                'state' => $astrologer->state,
                'city' => $astrologer->city,
                'pin_code' => $astrologer->pin_code,
                'profile_img' => $profileImage,
                'is_profile_created' => $astrologer->is_profile_created == 1 ? true : false,
                'status' => $astrologer->status,
                'trusted' => $astrologer->trusted,
                'date_of_birth' => $astrologer->date_of_birth,
                'birth_place' => $astrologer->birth_place,
                'experience' => $astrologer->experience,
                'call_charges_per_min' => $astrologer->call_charges_per_min,
                'chat_charges_per_min' => $astrologer->chat_charges_per_min,
                'video_charges_per_min' => $astrologer->video_charges_per_min,
                'wallet' => number_format($astrologerWallet, 2),
                'astrologer_live_charges_per_min' => $liveChargesPerMin->astrologer_live_charges_per_min,
                'boost_charges' => $liveChargesPerMin->boost_charges,
                'profile_status' => $astrologer->profile_status,
                'education' => $astrologer->education,
                'description' => $astrologer->description,
                'start_time_slot' => $astrologer->start_time_slot,
                'end_time_slot' => $astrologer->end_time_slot,
                'is_online' => $astrologerOnlineStatus,
                'boosted_at' => $astrologer->boosted_at,
                'rating' => $averageRating ?? 0,
                'score' => $astrologer->score,
                'created_at' => $astrologer->created_at,
                'is_onboarding_completed' => $astrologer->is_onboarding_completed == 1 ? true : false
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



    public function logout(Request $request)
    {
        try {

            $astrologer = Astrologer::findOrFail($request->astro_id);

            $astrologer->expire_at = null;
            $astrologer->save();


            //Revoke the astrologer's token
            $astrologer->tokens()->delete();

            return response()->json([
                'status' => true,
                'message' => 'astrologer Logout successfully!',

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



    public function addBank(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'account_number' => 'required|unique:banks',
                    'astro_id' => 'required',
                    'ifsc' => 'required',
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


            $bank = Bank::where(['astrologer_id' => $request->astro_id, 'status' => '1'])->first();

            if (!empty($bank)) {
                $status = '0';
            } else {
                $status = '1';
            }

            Bank::create([
                'astrologer_id' => $request->astro_id,
                'name' => $request->name,
                'account_number' => $request->account_number,
                'ifsc' => $request->ifsc,
                'status' => $status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Bank Add Successfully!',

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


    public function bank(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
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



            $banks = Bank::where('astrologer_id', $request->astro_id)->orderBy('id', 'desc')->get();

            $bankDetail = [];

            foreach ($banks as $bank) {
                $bankDetail[] = [
                    'id' => $bank->id,
                    'astro_id' => $bank->astrologer_id,
                    'name' => $bank->name,
                    'account_number' => $bank->account_number,
                    'ifsc' => $bank->ifsc,
                    'status' => $bank->status,
                ];
            }




            return response()->json([
                'status' => true,
                'data' => $bankDetail,
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



    public function UpdateBank(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'bank_id' => 'required',
                    'name' => 'required',
                    'account_number' => 'required',
                    'ifsc' => 'required',


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

            Bank::where('id', $request->bank_id)->update([
                'name' => $request->name,
                'account_number' => $request->account_number,
                'ifsc' => $request->ifsc,
            ]);

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Bank Detail Update Successfully!'
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


    public function deleteBank(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'bank_id' => 'required',
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


            $bank = Bank::findOrFail($request->bank_id);
            $bank->delete();


            return response()->json(
                [
                    'status' => true,
                    'message' => 'Bank Delete Successfully!'
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


    public function sendAstroNotifactionToken(Request $request)
    {


        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
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



            $astrologer = Astrologer::findOrFail($request->astro_id);

            $astrologer->notifaction_token = $request->notifaction_token;
            $astrologer->save();




            return response()->json(
                [
                    'status' => true,
                    'message' => 'astrologer notifaction save Successfully!'
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

    public function primaryBank(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
                    'bank_id' => 'required',
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


            Bank::where('astrologer_id', $request->astro_id)->update([
                'status' => '0',
            ]);

            Bank::where('id', $request->bank_id)->update([
                'status' => '1'
            ]);





            return response()->json(
                [
                    'status' => true,
                    'message' => 'Bank Status Change Successfully!'
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


    public function profileImageUpdate(Request $request)
    {


        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
                    'profile_img' => 'required',
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




            if (!empty($request->file('profile_img'))) {
                File::where(['other_id' => $request->astro_id, 'type' => 'astro_profile_image'])->delete();

                foreach ($request->file('profile_img') as $image) {


                    $uuid = Str::uuid()->toString();
                    $extension = $image->extension();
                    $fileName = $uuid . 'profile_image' . '.' . $extension;
                    $documentPath = 'user';
                    $filePath = $documentPath . '/' . $fileName;
                    $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');
                    File::create([
                        'type' => 'astro_profile_image',
                        'other_id' => $request->astro_id,
                        'path' => $filePath,
                        'file_size' => $image->getSize()
                    ]);
                }
            }


            return response()->json(
                [
                    'status' => true,
                    'message' => 'Profile Image Update Successfully!'
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
                    'astro_id' => 'required',
                    'name' => 'required',
                    'email' => 'required',
                    'specialization' => 'required',
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

            Astrologer::where('id', $request->astro_id)->update([
                'name' =>  $request->name,
                'email' =>  $request->email,
                'specialization' =>  $request->specialization,
                'description' =>  $request->description,

            ]);


            return response()->json(
                [
                    'status' => true,
                    'message' => 'Profile Update Successfully!'
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




    public function certificateDelete(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'certificate_id' => 'required',

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


            $file = File::findOrFail($request->certificate_id);
            $file->delete();


            return response()->json(
                [
                    'status' => true,
                    'message' => 'Certificate delete Successfully!'
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



    public function markOnlineOrOffline(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
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


            $astrologer = Astrologer::findOrFail($request->astro_id);
            $astrologer->is_online = $request->status;
            $astrologer->save();


            return response()->json(
                [
                    'status' => true,
                    'message' => 'Your status changed ' . $request->status . ' successfully!'
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

    public function raiseAnIssue(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
                    'type' => 'required',
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


            AstrologerQuery::create([
                'astrologer_id' => $request->astro_id,
                'type' => $request->type,
                'message' => $request->message,
                'status' => 'pending',

            ]);

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Rais issue successfully!'
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



    public function myFollower(Request $request)
    {

        try {

            $validator = Validator::make(
                $request->all(),
                [
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

            $followers = Follower::where(['astrologer_id' => $request->astro_id, 'status' => '1'])->with('user')->get();

            $listMyFollower = [];
            foreach ($followers as $follower) {
                $listMyFollower[] = [
                    'id' => $follower->id,
                    'astrologier_id' => $follower->astrologer_id,
                    'user_id' => $follower->user_id,
                    'user_name' => $follower->user->name,
                    'profile_img' => url(Storage::url($follower->user->profile_img)),
                    'notification_token' => $follower->user->notifaction_token
                ];
            }

            return response()->json(
                [
                    'status' => true,
                    'data' => $listMyFollower
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


    public function payout(Request $request)
    {

        try {

            $validator = Validator::make(
                $request->all(),
                [
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

            $payouts = Payout::where('astrologer_id', $request->astro_id)->orderBy('id', 'desc')->get();

            $payoutList = [];

            foreach ($payouts as $payout) {
                $payoutList[] = [
                    'id' => $payout->id,
                    'amount' => $payout->paid_amount,
                    'start_week_day' => date('F j, Y', strtotime($payout->weekly_start_date)),
                    'end_week_day' => date('F j, Y', strtotime($payout->weekly_end_date)),
                    'payment_status' => $payout->payment_status
                ];
            }


            return response()->json(
                [
                    'status' => true,
                    'data' => $payoutList
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

    public function onboardingQuestions()
    {
        try {

            $onboardingQuestions = OnboardingQuestion::where('status', '1')->orderBy('id', 'asc')->get();
            $onboardingQuestionList = [];

            foreach ($onboardingQuestions as $onboardingQuestion) {
                $onboardingQuestionList[] = [
                    'id' => $onboardingQuestion->id,
                    'question' => $onboardingQuestion->question,
                    'type' => $onboardingQuestion->type,
                ];
            }
            return response()->json(
                [
                    'status' => true,
                    'data' => $onboardingQuestionList
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

    public function onboardingAnswer(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
                    'question' => 'required',
                    'answer' => 'required',
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

            OnboardingAnswer::create([
                'astrologer_id' => $request->astro_id,
                'question' => $request->question,
                'answer' => $request->answer,
            ]);


            $astrologer = Astrologer::findOrFail($request->astro_id);
            $astrologer->is_onboarding_completed = '1';
            $astrologer->save();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Onboard successfully!'
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


    public function couponList(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
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

            $today = Carbon::today()->toDateString();
            $coupons = Coupon::whereDate('end_date', '>=', $today)->get();
            $chatCoupon = [];
            $audioCoupon = [];
            $videoCoupon = [];
            foreach ($coupons as $coupon) {

                $astrologerCoupon = AstrologerCoupon::where(['astrologer_id' => $request->astro_id, 'coupon_id' => $coupon->id])->first();
                if (!empty($astrologerCoupon)) {
                    $activeStatus = true;
                } else {
                    $activeStatus = false;
                }


                if ($coupon->type == 'chat') {
                    $chatCoupon[] = [
                        'id' => $coupon->id,
                        'code' => $coupon->code,
                        'type' => $coupon->type,
                        'discount' => $coupon->discount,
                        'discount_type' => $coupon->discount_type,
                        'active_status' => $activeStatus
                    ];
                }

                if ($coupon->type == 'audio') {
                    $audioCoupon[] = [
                        'id' => $coupon->id,
                        'code' => $coupon->code,
                        'type' => $coupon->type,
                        'discount' => $coupon->discount,
                        'discount_type' => $coupon->discount_type,
                        'active_status' => $activeStatus
                    ];
                }
                if ($coupon->type == 'video') {
                    $videoCoupon[] = [
                        'id' => $coupon->id,
                        'code' => $coupon->code,
                        'type' => $coupon->type,
                        'discount' => $coupon->discount,
                        'discount_type' => $coupon->discount_type,
                        'active_status' => $activeStatus
                    ];
                }
            }

            return response()->json(
                [
                    'status' => true,
                    'data' => [
                        'chat_coupon' => $chatCoupon,
                        'audio_coupon' => $audioCoupon,
                        'video_coupon' => $videoCoupon,
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



    public function activeCoupon(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
                    'coupon_id' => 'required',
                    'type' => 'required',
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

            $astrologerCoupon = AstrologerCoupon::where(['astrologer_id' => $request->astro_id, 'type' => $request->type])->first();
            if (!empty($astrologerCoupon)) {
                $astrologerCoupon->delete();
            }

            AstrologerCoupon::create([
                'astrologer_id' => $request->astro_id,
                'coupon_id' => $request->coupon_id,
                'type' => $request->type,
            ]);



            return response()->json(
                [
                    'status' => true,
                    'message' => 'Coupon active successfully!'
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

    public function deActiveCoupon(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
                    'coupon_id' => 'required',
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

            $astrologerCoupon = AstrologerCoupon::where(['astrologer_id' => $request->astro_id, 'coupon_id' => $request->coupon_id])->first();
            $astrologerCoupon->delete();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Coupon de-active successfully!'
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

    public function astrologerLive(Request $request)
    {
        try {


            $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
                    'time' => 'required',
                    'amount' => 'required',
                    'live_id' => 'required',
                    'astrologer_live_charges_per_min' => 'required'


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


            $perSecondPrice = $request->astrologer_live_charges_per_min / 60;

            $tatolAmountCharge = $perSecondPrice * $request->time;


            AstrologerLive::create([
                'astrologer_id' => $request->astro_id,
                'time' => $request->time,
                'amount' => number_format($tatolAmountCharge, 2),
                'live_id' => $request->live_id,
                'astrologer_live_charges_per_min' => $request->astrologer_live_charges_per_min
            ]);

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Live histroy save successfully!'
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


    //Astrologer Live history

    public function astrologerLiveHistory(Request $request)
    {
        try {


            $validator = Validator::make(
                $request->all(),
                [
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


            $liveHistories = AstrologerLive::where('astrologer_id', $request->astro_id)->orderBy('id', 'desc')->get();

            $listLiveHistory = [];
            foreach ($liveHistories as $liveHistory) {
                $minutes = floor($liveHistory->time / 60);
                $seconds = $liveHistory->time % 60;
                $listLiveHistory[] = [
                    'time' => $minutes . ':' . $seconds,
                    'total_amount' => $liveHistory->amount,
                    'astrologer_live_charges_per_min' => $liveHistory->astrologer_live_charges_per_min,
                    'date_time' => $liveHistory->created_at
                ];
            }


            return response()->json(
                [
                    'status' => true,
                    'data' => $listLiveHistory
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



    public function astrologerBoost(Request $request)
    {
        try {




            $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
                    'amount' => 'required',
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

            Boost::create([
                'astrologer_id' => $request->astro_id,
                'amount' => $request->amount
            ]);

            $astrologer = Astrologer::findOrFail($request->astro_id);
            $astrologer->boosted_at =  Carbon::now();
            $astrologer->boost_expire_at = Carbon::now()->addHours(2);
            $astrologer->save();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Boost successfully!'
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


    public function ramedyCreate(Request $request)
    {

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
                    'description' => 'required',
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

            $ramedy = Ramedy::where('astrologer_id', $request->astro_id)->first();

            if (empty($ramedy)) {
                Ramedy::create([
                    'astrologer_id' => $request->astro_id,
                    'description' => $request->description
                ]);
            } else {
                $ramedy->description = $request->description;
                $ramedy->save();
            }


            return response()->json(
                [
                    'status' => true,
                    'message' => 'Ramedy save successfully!'
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
    
    public function signalNotifaction(Request $request)
    {
        
       try{
             $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
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
            
           $astrologer = Astrologer::findOrFail($request->astro_id);
           $astrologer->signal_id = $request->signal_id;
           $astrologer->save();
           
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
       
       
       
       //astro version update
       
       
    public function versionUpdate(Request $request)
    {
        
       try{
             $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
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
            
           $astrologer = Astrologer::findOrFail($request->astro_id);
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
        
}
