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
        Schema::create('user_enquiries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('vendor_business_category_detail_id');
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('email');
            $table->string('number_of_room');
            $table->string('number_of_guest');
            $table->json('booking_date');
            $table->enum('function_type', ['Pre Wedding', 'Wedding'])->default('Pre Wedding');
            $table->enum('function_time', ['Day', 'Evening'])->default('Day');
            $table->enum('notify_me_on_whatsapp', ['0', '1'])->default('0');
            $table->enum('status', ['0', '1'])->default('1');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_enquiries');
    }
};
