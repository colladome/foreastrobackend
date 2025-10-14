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
        Schema::create('booking_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('booking_user_id')->nullable();
            $table->unsignedBigInteger('vendor_business_category_detail_id')->nullable();
            $table->string('description')->nullable();
            $table->string('booking_date');
            $table->string('type')->nullable();
            $table->enum('status', ['0', '1'])->default('0')->comment('Status: active =>1 and inactive =>0');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_dates');
    }
};
