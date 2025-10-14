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
        Schema::create('communications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('astrologer_id');
            $table->string('communication_id')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->string('time')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('astrologer_payment_date')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('coupon_applied')->nullable();
            $table->string('coupon_discount_amount')->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */


    public function down(): void
    {
        Schema::dropIfExists('communications');
    }
};
