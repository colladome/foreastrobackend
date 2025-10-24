<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Communication;
use App\Models\Astrologer;
use App\Models\AstrologerLive;
use App\Models\Boost;
use App\Models\User;
use App\Models\Payout;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;


class PayoutWeeklyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:payout-weekly-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Payout weekly update';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $astrologers = Astrologer::where(['status' => '1', 'profile_status' => 'approved'])->get();






        foreach ($astrologers as $astrologer) {

            $communucations = Communication::where(['astrologer_id' => $astrologer->id, 'status' => 'accept'])
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->get();

            $totalAmount = 0;
            $commissionAmount = 0;
            $liveAmount = 0;
            $couponDiscountAmount = 0;

            $communicationIds = [];

            foreach ($communucations as $communucation) {

                $finalAmount = $communucation->total_amount;
                $finalAmount = str_replace(',', '', $finalAmount);
                $amount = (float)$finalAmount + $communucation->coupon_discount_amount ?? 0;
                $totalAmount += number_format($amount, 2, '.', '');
                $commissionAmount += ($amount * $astrologer->commission_percent / 100);
                $couponDiscountAmount += $communucation->coupon_discount_amount;
                $communicationIds[] = $communucation->id;
            }




            $paidAmount = $totalAmount - ($couponDiscountAmount + $commissionAmount + $liveAmount);

            $liveTotalAmount = AstrologerLive::where('astrologer_id', $astrologer->id)
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount');

                $boostTotalAmount = Boost::where('astrologer_id', $astrologer->id)
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount');

            $liveIds = AstrologerLive::where('astrologer_id', $astrologer->id)
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->pluck('id')->toArray();

                $boostIds = Boost::where('astrologer_id', $astrologer->id)
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->pluck('id')->toArray();

            $totalSubtractAmoun = $liveTotalAmount + $astrologer->wallet+$boostTotalAmount;

            if ($paidAmount >= $totalSubtractAmoun) {

                $creditAmount = $astrologer->wallet;
                $finalPaidAmount = $paidAmount - $totalSubtractAmoun;
                $astrologer->wallet = 0;
                $astrologer->save();
            } else {

                $finalPaidAmount = 0;
                $creditAmount = ($totalSubtractAmoun - $paidAmount) - $astrologer->wallet;

                $astrologer->wallet = $totalSubtractAmoun - $paidAmount;
                $astrologer->save();
            }



            if (!empty($communicationIds)) {

                Payout::create([
                    'astrologer_id' => $astrologer->id,
                    'total_amount' => number_format($totalAmount, 2),
                    'commission_amount' =>  number_format($commissionAmount, 2),
                    'coupon_discount_amount' => number_format($couponDiscountAmount, 2),
                    'live_amount' => number_format($liveTotalAmount, 2),
                    'boost_amount' => number_format($boostTotalAmount, 2),
                    'credit_amount' => number_format($creditAmount, 2),
                    'paid_amount' =>  number_format($finalPaidAmount, 2),
                    'communication_id' => $communicationIds,
                    'live_id' => $liveIds,
                    'boost_id' => $boostIds,
                    'weekly_start_date' => Carbon::now()->startOfWeek(),
                    'weekly_end_date' => Carbon::now()->endOfWeek(),
                    'payment_status' => 'pending',
                ]);
            }
        }
        Log::info('Payout create successfully.');
        // $this->info('Payout create successfully.');
    }
}
