<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Communication;
use Illuminate\Support\Facades\Storage;
use App\Models\Payout;


class CommunicationController extends Controller
{


    public function sendRequest(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'astro_id' => 'required',
                    'user_id' => 'required',
                    'type' => 'required',
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
            
            
            
            $communication = Communication::where(['user_id' => $request->user_id, 'astrologer_id' => $request->astro_id, 'status' => 'pending'])->first();
            if(!empty($communication))
            {
               return response()->json([
                    'status' => true,
                     'message' => 'You have alredy send the request',
                ], 203); 
            }
            

            Communication::create([

                'astrologer_id' => $request->astro_id,
                'user_id' => $request->user_id,
                'type' => $request->type,
                'communication_id' => $request->communication_id,
                'status' => $request->status,
                'coupon_applied' => $request->coupon_applied,

            ]);

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Request send Successfully!'
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


    public function getCommunicationRequest(Request $request)
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


            $communications =  Communication::where(['astrologer_id' => $request->astro_id, 'status' => 'pending', 'type' => 'chat'])->with('user')->get();

            $listChatRequest = [];
            foreach ($communications as $communication) {
                // if(!empty($communication->user->id))
                // {
                $time = date("h:i A", strtotime($communication->created_at));
                $date = date("d/m/Y", strtotime($communication->created_at));
                $listChatRequest[] = [
                    'id' => $communication->id,
                    'user_id' => $communication->user->id,
                    'user_wallet' => round($communication->user->wallet),
                    'name' => $communication->user->name,
                    'profile_pic' => url(Storage::url($communication->user->profile_img)),
                    'date' => $date,
                    'time' => $time,
                    'communication_id' => $communication->communication_id,
                    'status' => $communication->status,
                    'type' => $communication->type,
                ];
               // }
            }


            //call


            $callCommunications =  Communication::where(['astrologer_id' => $request->astro_id, 'status' => 'pending', 'type' => 'call'])->with('user')->get();

            $listCallRequest = [];
            foreach ($callCommunications as $communication) {
                $time = date("h:i A", strtotime($communication->created_at));
                $date = date("d/m/Y", strtotime($communication->created_at));
                $listCallRequest[] = [
                    'id' => $communication->id,
                    'user_id' => $communication->user->id,
                    'user_wallet' => round($communication->user->wallet),
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





    public function allCommunicationRequest(Request $request)
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


            $communications =  Communication::orderBy('id', 'asc')->where(['astrologer_id' => $request->astro_id, 'status' => 'pending'])->with('user')->get();

            $listCommunicationRequest = [];
            foreach ($communications as $communication) {
                $time = date("h:i A", strtotime($communication->created_at));
                $date = date("d/m/Y", strtotime($communication->created_at));
                $listCommunicationRequest[] = [
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
                    'data' => $listCommunicationRequest

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



    // public function getCommunicationCallRequest(Request $request)
    // {
    //     try {

    //         $validator = Validator::make(
    //             $request->all(),
    //             [
    //                 'astro_id' => 'required',

    //             ]
    //         );

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'error' => [
    //                     'code' => 401,
    //                     'message' => 'validation error',
    //                 ],
    //                 'data' => $validator->errors()
    //             ], 401);
    //         }


    //         $communications =  Communication::where(['astrologer_id' => $request->astro_id, 'status' => 'pending', 'type' => 'call'])->with('user')->get();

    //         $listRequest = [];
    //         foreach ($communications as $communication) {


    //             $time = date("h:i A", strtotime($communication->created_at));
    //             $date = date("d/m/Y", strtotime($communication->created_at));
    //             $listRequest = [
    //                 'id' => $communication->id,
    //                 'user_id' => $communication->user->id,
    //                 'name' => $communication->user->name,
    //                 'profile_pic' => url(Storage::url($communication->user->profile_img)),
    //                 'date' => $date,
    //                 'time' => $time,
    //                 'communication_id' => $communication->communication_id,
    //                 'status' => $communication->status,
    //                 'type' => $communication->type,


    //             ];
    //         }


    //         return response()->json(
    //             [
    //                 'status' => true,
    //                 'data' => $listRequest
    //             ],
    //             201
    //         );
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'error' => [
    //                 'code' => 500,
    //                 'message' =>  $th->getMessage(),
    //             ]
    //         ], 500);
    //     }
    // }











    public function updateCommunicationStatus(Request $request)
    {

        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'communication_id' => 'required',
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


            $communication = Communication::findOrFail($request->communication_id);
            $communication->status = $request->status;
            $communication->save();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Communication update Successfully!'
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


 public function todayCommunicationLog(Request $request)
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

        // Add orderBy to sort by created_at in descending order
        $todayCommunications = Communication::where('astrologer_id', $request->astro_id)
            ->where('status', '!=', 'pending')
            ->whereDate('created_at', $today)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $listTodayLogs = [];

        foreach ($todayCommunications as $todayCommunication) {
            $time = date("h:i A", strtotime($todayCommunication->created_at));
            $date = date("d/m/Y", strtotime($todayCommunication->created_at));

            $communicitionTime = $todayCommunication->time / 60;

            $listTodayLogs[] = [
                'id' => $todayCommunication->id,
                'user_id' => $todayCommunication->user->id,
                'name' => $todayCommunication->user->name,
                'profile_pic' => url(Storage::url($todayCommunication->user->profile_img)),
                'date' => $date,
                'time' => $time,
                'communication_id' => $todayCommunication->communication_id,
                'status' => $todayCommunication->status,
                'type' => $todayCommunication->type,
                'communicition_time' => number_format($communicitionTime, 2),
                'total_amount' => $todayCommunication->total_amount,
                'per_min_charge' => $todayCommunication->astro_per_min_charge,
            ];
        }

        return response()->json(
            [
                'status' => true,
                'data' => $listTodayLogs
            ],
            201
        );
    } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'error' => [
                'code' => 500,
                'message' => $th->getMessage(),
            ]
        ], 500);
    }
}



    public function chatLog(Request $request)
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


            $chatLogs = Communication::orderBy('created_at', 'desc')->where(['astrologer_id' => $request->astro_id, 'type' => 'chat'])->with('user')->get();


            $listChatLogs = [];

            foreach ($chatLogs as $chatLog) {
                $time = date("h:i A", strtotime($chatLog->created_at));
                $date = date("d/m/Y", strtotime($chatLog->created_at));
                $communicitionTime = $chatLog->time / 60;

                $listChatLogs[] = [
                    'id' => $chatLog->id,
                    'user_id' => $chatLog->user->id,
                    'name' => $chatLog->user->name,
                    'profile_pic' => url(Storage::url($chatLog->user->profile_img)),
                    'date' => $date,
                    'time' => $time,
                    'communication_id' => $chatLog->communication_id,
                    'status' => $chatLog->status,
                    'type' => $chatLog->type,
                    'communicition_time' => number_format($communicitionTime, 2),
                    'total_amount' => $chatLog->total_amount,
                    'per_min_charge' => $chatLog->astro_per_min_charge,
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


    public function callLog(Request $request)
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

            $callLogs = Communication::orderBy('created_at', 'desc')->where('astrologer_id', $request->astro_id)
                ->where('type', '!=', 'chat')
                ->with('user')
                ->get();
            $listCallLogs = [];

            foreach ($callLogs as $callLog) {
                $time = date("h:i A", strtotime($callLog->created_at));
                $date = date("d/m/Y", strtotime($callLog->created_at));
                $communicitionTime = $callLog->time / 60;

                $listCallLogs[] = [
                    'id' => $callLog->id,
                    'user_id' => $callLog->user->id,
                    'name' => $callLog->user->name,
                    'profile_pic' => url(Storage::url($callLog->user->profile_img)),
                    'date' => $date,
                    'time' => $time,
                    'communication_id' => $callLog->communication_id,
                    'status' => $callLog->status,
                    'type' => $callLog->type,
                    'communicition_time' => number_format($communicitionTime, 2),
                    'total_amount' => $callLog->total_amount,
                    'per_min_charge' => $callLog->astro_per_min_charge,
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


    public function myPaymentHistory(Request $request)
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

            $callLogs = Communication::where('astrologer_id', $request->astro_id)
                ->where('status', 'accept')
                ->with('user')
                ->orderBy('id', 'desc')
                ->get();
            $listCallLogs = [];

            foreach ($callLogs as $callLog) {
                $time = date("h:i A", strtotime($callLog->created_at));
                $date = date("d/m/Y", strtotime($callLog->created_at));
                $communicitionTime = $callLog->time / 60;

                $listCallLogs[] = [
                    'id' => $callLog->id,
                    'user_id' => $callLog->user->id,
                    'name' => $callLog->user->name,
                    'profile_pic' => url(Storage::url($callLog->user->profile_img)),
                    'date' => $date,
                    'time' => $time,
                    'communication_id' => $callLog->communication_id,
                    'status' => $callLog->status,
                    'type' => $callLog->type,
                    'communicition_time' => number_format($communicitionTime, 2),
                    'total_amount' => number_format($callLog->total_amount, 2),
                    'per_min_charge' => $callLog->astro_per_min_charge,
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
    public function astrologerRecords(Request $request)
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



            $countCalls =  Communication::where(['astrologer_id' => $request->astro_id, 'type' => 'audio', 'status' => 'accept'])->count();
            $countVideoCalls =  Communication::where(['astrologer_id' => $request->astro_id, 'type' => 'video', 'status' => 'accept'])->count();
            $countChats =  Communication::where(['astrologer_id' => $request->astro_id, 'type' => 'chat', 'status' => 'accept'])->count();
            $totalEarning =  Payout::where(['astrologer_id' => $request->astro_id])->sum('paid_amount');
            $totalEarning = number_format($totalEarning, 2);
            return response()->json(
                [
                    'status' => true,
                    'number_of_audio_call' => $countCalls,
                    'number_of_video_calls' => $countVideoCalls,
                    'number_of_chats' =>  $countChats,
                    'total_earning' =>  $totalEarning
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
}
