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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('vendor_business_category_detail_id');
            $table->unsignedBigInteger('category_id');
            $table->string('number_of_room')->nullable();
            $table->string('number_of_guest')->nullable();
            $table->json('booking_date')->nullable();
            $table->enum('function_type', ['Pre Wedding', 'Wedding'])->default('Pre Wedding');
            $table->enum('function_time', ['Day', 'Evening'])->default('Day');
            $table->string('product_name')->nullable();
            $table->string('price')->nullable();
            $table->json('image')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->enum('vendor_view_status', ['0', '1'])->default('0');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
