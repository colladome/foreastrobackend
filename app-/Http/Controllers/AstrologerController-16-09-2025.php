<?php

namespace App\Http\Controllers;

use App\Models\Astrologer;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Requests\AstrologerRequest;
use App\Models\AstrologerLive;
use App\Models\Boost;
use App\Models\Celebrity;
use App\Models\Communication;
use App\Models\File;
use App\Models\Payment;
use App\Models\Payout;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\OnboardingQuestion;

class AstrologerController extends Controller
{
    public function index(Request $request)
    {
        $astrologers = Astrologer::orderBy('id', 'desc')->get();
        return view('backend.astrologers.index', compact('astrologers'));
    }

    public function create()
    {
        return view('backend.astrologers.create');
    }

    public function store(AstrologerRequest $request)
    {

        Astrologer::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'gender' => $request->gender,
        ]);

        return redirect()->route('admin.astrologers')->with('success', 'Astrologer Add Successfully!');
    }



    public function view($id)
    {
        $astrologer = Astrologer::findOrFail($id);
        $banks = Bank::where('astrologer_id', $id)->get();
        return view('backend.astrologers.view', compact('astrologer', 'banks'));
    }

    public function delete($id)
    {
        $astrologer = Astrologer::findOrFail($id);
        $astrologer->delete();
        return back()->with('success', 'Astrologer delete successfully!');
    }


    public function active($id, $status)
    {

        $astrologer = Astrologer::findOrFail($id);
        $astrologer->profile_status = $status;
        $astrologer->save();

        return back()->with('success', 'Astrologer status update successfully!');
    }


    public function commissionPercent(Request $request, $id)
    {
        $astrologer = Astrologer::findOrFail($id);
        $astrologer->commission_percent = $request->commission_percent;
        $astrologer->commission_descreption = $request->commission_descreption;
        $astrologer->call_charges_per_min = $request->call_charges_per_min;
        $astrologer->chat_charges_per_min = $request->chat_charges_per_min;
        $astrologer->video_charges_per_min = $request->video_charges_per_min;
        $astrologer->score = $request->score;
        $astrologer->save();
        return back()->with('success', 'Commission Update Successfully!');
    }

    public function walletTransaction()
    {
        $payments = Payment::orderBy('id', 'desc')->get();
        return view('backend.user.walletTransaction', compact('payments'));
    }
    
    
    
     public function UserWalletTransaction($id)
    {
        $payments = Payment::where('user_id', $id)->orderBy('id', 'desc')->get();
        return view('backend.user.walletTransaction', compact('payments'));
    }


    public function celebrityList()
    {
        $celebrities = Celebrity::orderBy('id', 'desc')->get();
        return view('backend.celebrity.index', compact('celebrities'));
    }


    public function celebrityCreate()
    {
        return view('backend.celebrity.create');
    }


    public function celebrityStore(Request $request)
    {


        $thumbnail = $request->file('thumbnail');
        if ($thumbnail) {
            $uuid = Str::uuid()->toString();
            $extension = $request->file('thumbnail')->extension();
            $fileName = $uuid . 'thumbnail' . '.' . $extension;
            $documentPath = 'thumbnail';
            $filePath = $documentPath . '/' . $fileName;


            $storedFilePath = $thumbnail->storeAs($documentPath, $fileName, 'public');
        }


        $video = $request->file('video');
        if ($video) {
            $uuid = Str::uuid()->toString();
            $extension = $request->file('video')->extension();
            $fileName = $uuid . 'video' . '.' . $extension;
            $documentPath = 'video';
            $videoFilePath = $documentPath . '/' . $fileName;


            $storedFilePath = $video->storeAs($documentPath, $fileName, 'public');
        }


        Celebrity::create([
            'title' => $request->title,
            'thumbnail' => $filePath,
            'video_path' => $videoFilePath
        ]);


        return redirect()->route('admin.celebrity.celebrityList')->with('success', 'Celebrity add successfully!');

        // return view('backend.celebrity.create');
    }


    public function celebrityDelete($id)
    {
        $celebrity = Celebrity::findOrFail($id);
        $celebrity->delete();
        return redirect()->route('admin.celebrity.celebrityList')->with('success', 'Celebrity delete successfully!');
    }

    public function celebrityEdit($id)
    {
        $celebrity = Celebrity::findOrFail($id);
        return view('backend.celebrity.edit', compact('celebrity'));
    }

    public function celebrityUpdate(Request $request, $id)
    {

        $celebrity = Celebrity::findOrFail($id);

        $thumbnail = $request->file('thumbnail');
        if ($thumbnail) {
            $uuid = Str::uuid()->toString();
            $extension = $request->file('thumbnail')->extension();
            $fileName = $uuid . 'thumbnail' . '.' . $extension;
            $documentPath = 'thumbnail';
            $filePath = $documentPath . '/' . $fileName;


            $storedFilePath = $thumbnail->storeAs($documentPath, $fileName, 'public');
        } else {
            $filePath = $celebrity->thumbnail;
        }


        $video = $request->file('video');
        if ($video) {
            $uuid = Str::uuid()->toString();
            $extension = $request->file('video')->extension();
            $fileName = $uuid . 'video' . '.' . $extension;
            $documentPath = 'video';
            $videoFilePath = $documentPath . '/' . $fileName;


            $storedFilePath = $video->storeAs($documentPath, $fileName, 'public');
        } else {
            $videoFilePath = $celebrity->video_path;
        }


        Celebrity::where('id', $id)->update([
            'title' => $request->title,
            'thumbnail' => $filePath,
            'video_path' => $videoFilePath
        ]);


        return redirect()->route('admin.celebrity.celebrityList')->with('success', 'Celebrity Update successfully!');
    }


    public function paymentManagement()
    {

        $totalCallAndChats = 0;
        $totalAmount = 0;
        $date  = '';
        $paymentStatus = '';
        $astroName = '';
        $payments = Communication::orderBy('id', 'desc')->where('status', 'accept')->with('user','astrologer')->get();

        return view('backend.payment_management.index', compact('payments', 'date', 'paymentStatus','astroName','totalCallAndChats','totalAmount'));
    }


    public function paymentCompleted($id)
    {
        $payment = Communication::findOrFail($id);
        $payment->payment_status = 'completed';
        $payment->astrologer_payment_date = now();
        $payment->save();

        return back()->with('success', 'Payment Status changed!');
    }



    public function paymentPending($id)
    {
        $payment = Communication::findOrFail($id);
        $payment->payment_status = 'pending';
        $payment->astrologer_payment_date = null;
        $payment->save();


        return back()->with('success', 'Payment Status changed!');
    }

    public function paymentDelete($id)
    {
        $payment = Communication::findOrFail($id);
        $payment->delete();

        return back()->with('success', 'Payment delete successfully!');
    }






    public function paymentView($id)
    {
        $payment = Communication::with('user', 'astrologer')->findOrFail($id);
        $bank = Bank::where(['astrologer_id' => $payment->astrologer_id, 'status' => '1'])->first();
        return view('backend.payment_management.view', compact('payment', 'bank'));
    }


    public function paymentFilter(Request $request)
    {
        $totalCallAndChats = 0;
        $totalAmount = 0;
        if(!empty($request->astrologer_name))
        {
        $astrologerIds = Astrologer::where('name',$request->astrologer_name)->pluck('id')->toArray();   
        $query = Communication::whereIn('astrologer_id',$astrologerIds)->orderBy('id', 'desc')->where('status', 'accept')->with('user','astrologer');
        $totalCallAndChats = Communication::whereIn('astrologer_id',$astrologerIds)->orderBy('id', 'desc')->where('status', 'accept')->with('user','astrologer')->count();
        $totalAmount = Communication::whereIn('astrologer_id',$astrologerIds)->orderBy('id', 'desc')->where('status', 'accept')->with('user','astrologer')->sum('total_amount');


        

        }else
        {
        $query = Communication::orderBy('id', 'desc')->where('status', 'accept')->with('user','astrologer');

        }

        if (!empty($request->date && $request->date == 'daily')) {
            $query->whereDate('created_at', Carbon::today());
        }
        if (!empty($request->date && $request->date == 'weekly')) {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        }
        if (!empty($request->date && $request->date == 'monthly')) {
            $query->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year);
        }

        if (!empty($request->payment_status)) {
            $query->where('payment_status', $request->payment_status);
        }

        $payments = $query->get();


        $date  = $request->date;
        $paymentStatus = $request->payment_status;
        $astroName = $request->astrologer_name;


        return view('backend.payment_management.index', compact('payments', 'date', 'paymentStatus','totalCallAndChats','totalAmount','astroName'));
    }




    public function astrologerReport(Request $request)
    {
          $astroMobile = $request->mobile_number ?? '';
          
          $astroDate = $request->date ?? '';
            $hours = 0;
              $minutes = 0;
              $seconds = 0;
              $callHours = 0;
              $callMinutes = 0;
              $callSeconds = 0;
              $chatHours = 0;
              $chatMinutes = 0;
              $chatSeconds = 0;
              $countAstroRejectRequest = 0;
          if(!empty($astroMobile))
          {
              $astrologer = Astrologer::where('mobile_number', $astroMobile)->first();
              
              
              // Get the query object
            $query = AstrologerLive::where('astrologer_id', $astrologer->id);
            
            // Apply date filters based on the filter type
            switch ($astroDate) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
            
                case 'weekly':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
            
                case 'monthly':
                    $query->whereMonth('created_at', Carbon::now()->month)
                          ->whereYear('created_at', Carbon::now()->year);
                    break;
            
                case 'yearly':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
            
                case 'total':
                default:
                    // No additional filter for 'total'
                    break;
            }
              
          
              $astrologerLive = $query->sum('time');
              // Calculate hours, minutes, and seconds
                $hours = floor($astrologerLive / 3600);
                $minutes = floor(($astrologerLive % 3600) / 60);
                $seconds = $astrologerLive % 60;
                
                
               // echo 'Houres'.$hours.'Minut'.$minutes.'second'.$seconds;die;
               
               
               
               
               
               //total call time
               
                $query1 = Communication::where('astrologer_id', $astrologer->id)->where('type', '!=', 'chat');
                   switch ($astroDate) {
                case 'today':
                    $query1->whereDate('created_at', Carbon::today());
                    break;
            
                case 'weekly':
                    $query1->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
            
                case 'monthly':
                    $query1->whereMonth('created_at', Carbon::now()->month)
                          ->whereYear('created_at', Carbon::now()->year);
                    break;
            
                case 'yearly':
                    $query1->whereYear('created_at', Carbon::now()->year);
                    break;
            
                case 'total':
                default:
                    // No additional filter for 'total'
                    break;
            }
            
            
            
            
            $astroCallTime = $query1->sum('time');
           // print_r();die;
              // Calculate hours, minutes, and seconds
                $callHours = floor($astroCallTime / 3600);
                $callMinutes = floor(($astroCallTime % 3600) / 60);
                $callSeconds = $astroCallTime % 60;
              
              
              
              
              
               
               //total chat time
               
                $query2 = Communication::where('astrologer_id', $astrologer->id)->where('type', 'chat');
                   switch ($astroDate) {
                case 'today':
                    $query2->whereDate('created_at', Carbon::today());
                    break;
            
                case 'weekly':
                    $query2->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
            
                case 'monthly':
                    $query2->whereMonth('created_at', Carbon::now()->month)
                          ->whereYear('created_at', Carbon::now()->year);
                    break;
            
                case 'yearly':
                    $query2->whereYear('created_at', Carbon::now()->year);
                    break;
            
                case 'total':
                default:
                    // No additional filter for 'total'
                    break;
            }
            
            
            
            
            $astroChatTime = $query2->sum('time');
           // print_r();die;
              // Calculate hours, minutes, and seconds
                $chatHours = floor($astroChatTime / 3600);
                $chatMinutes = floor(($astroChatTime % 3600) / 60);
                $chatSeconds = $astroChatTime % 60;
              
              
              
              //total count reject request
               
                $query3 = Communication::where('astrologer_id', $astrologer->id)->where('status', 'reject');
                   switch ($astroDate) {
                case 'today':
                    $query3->whereDate('created_at', Carbon::today());
                    break;
            
                case 'weekly':
                    $query3->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
            
                case 'monthly':
                    $query3->whereMonth('created_at', Carbon::now()->month)
                          ->whereYear('created_at', Carbon::now()->year);
                    break;
            
                case 'yearly':
                    $query3->whereYear('created_at', Carbon::now()->year);
                    break;
            
                case 'total':
                default:
                    // No additional filter for 'total'
                    break;
            }
            
            
            
            
            $countAstroRejectRequest = $query3->count();
              
              
          }
         
         return view('backend.report.view',compact('astroMobile','astroDate','hours','minutes','seconds','callHours','callMinutes','callSeconds','chatHours','chatMinutes','chatSeconds', 'countAstroRejectRequest')); 
        
    }

    public function payout()
    {
        $name  = '';
        $paymentStatus = '';
        $payouts = Payout::orderBy('id', 'desc')->with('astrologer')->get();
        return view('backend.payout.index', compact('payouts', 'name', 'paymentStatus'));
    }


    public function payoutCompleted($id)
    {
        $payout = Payout::findOrFail($id);
        foreach ($payout->communication_id as $payoutPaymentStatusId) {
            Communication::where('id', $payoutPaymentStatusId)->update(['payment_status' => 'completed']);
        }
        $payout->payment_status = 'completed';
        $payout->save();
        return back()->with('success', 'Payment Status changed!');
    }



    public function payoutPending($id)
    {
        $payout = Payout::findOrFail($id);


        foreach ($payout->communication_id as $payoutPaymentStatusId) {
            Communication::where('id', $payoutPaymentStatusId)->update(['payment_status' => 'pending']);
        }

        $payout->payment_status = 'pending';
        $payout->save();
        return back()->with('success', 'Payment Status changed!');
    }

    public function payoutFilter(Request $request)
    {
        $astrologerIds = Astrologer::where('name', 'like', '%' . $request->name . '%')->pluck('id')->toArray();
        $query = Payout::orderBy('id', 'desc')->with('astrologer');
        if (!empty($request->name)) {
            $query->whereIn('astrologer_id', $astrologerIds);
        }
        if (!empty($request->payment_status)) {
            $query->where('payment_status', $request->payment_status);
        }

        $payouts = $query->get();

        $name  = $request->name;
        $paymentStatus = $request->payment_status;

        return view('backend.payout.index', compact('payouts', 'paymentStatus', 'name'));
    }



    public function payoutView($id)
    {

        $payout = Payout::findOrFail($id);
        $communications = Communication::whereIn('id', $payout->communication_id)->with('user', 'astrologer')->get();
        $bank = Bank::where(['astrologer_id' => $payout->astrologer_id, 'status' => '1'])->first();
        $astrologer = Astrologer::findOrFail($payout->astrologer_id);

        $lives = AstrologerLive::whereIn('id', $payout->live_id ?? [])->with('astrologer')->get();
        $boosts = Boost::whereIn('id', $payout->boost_id ?? [])->with('astrologer')->get();
        

        return view('backend.payout.view', compact('payout', 'communications', 'bank', 'astrologer', 'lives','boosts'));
    }


    public function onboardingQuestion()
    {
        $onboardingQuestions = OnboardingQuestion::orderBy('id', 'desc')->get();
        return view('backend.onboarding.index', compact('onboardingQuestions'));
    }


    public function questionCreate()
    {
        return view('backend.onboarding.create');
    }

    public function questionStore(Request $request)
    {
        OnboardingQuestion::create([
            'question' => $request->question,
            'type' => $request->type,
        ]);

        return redirect()->route('admin.question.index')->with('success', 'Question save successfully!');
    }


    public function questionUpdate(Request $request, $id)
    {
        OnboardingQuestion::where('id', $id)->update([
            'question' => $request->question,
            'type' => $request->type,
        ]);

        return redirect()->route('admin.question.index')->with('success', 'Question update successfully!');
    }

    public function questionDelete($id)
    {
        $onboardingQuestion = OnboardingQuestion::findOrFail($id);
        $onboardingQuestion->delete();
        return back()->with('success', 'Question delete successfully!');
    }



    public function questionEdit($id)
    {
        $question = OnboardingQuestion::findOrFail($id);
        return view('backend.onboarding.edit', compact('question'));
    }


    public function questionActive($id)
    {
        $question = OnboardingQuestion::findOrFail($id);
        $question->status = '1';
        $question->save();
        return back()->with('success', 'Question Activated!');
    }
    public function questionInActive($id)
    {
        $question = OnboardingQuestion::findOrFail($id);
        $question->status = '0';
        $question->save();
        return back()->with('success', 'Question In-Activated!');
    }


    public function approve($id,$astroId)
    {
        File::where(['type' => 'astro_profile_image', 'other_id' => $astroId])->update(['status' => '0']);
        $file = File::findOrFail($id);
        $file->status = '1';
        $file->save();
        return back()->with('success', 'Profile Image Approved!');
    }
}
