<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('astrologer_id');
            $table->string('total_amount')->default(0);
            $table->string('commission_amount')->default(0);
            $table->string('live_amount')->default(0);
            $table->string('paid_amount')->default(0);
            $table->json('communication_id')->nullable();
            $table->json('live_id')->nullable();

            $table->string('total_coupon_discount')->default(0);
            $table->string('credit_amount')->default(0);
            $table->string('weekly_start_date')->nullable();
            $table->string('weekly_end_date')->nullable();
            $table->string('payment_status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payouts');
    }
};
