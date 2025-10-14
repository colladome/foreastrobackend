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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('sky_order_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('billing_name');
            $table->string('billing_email');
            $table->string('number_of_item')->nullable();
            $table->string('billing_address');
            $table->string('billing_address2')->nullable();
            $table->string('state');
            $table->string('city');
            $table->string('zip');
            $table->string('total_amount');
            $table->string('payment_status');
            $table->enum('order_status', ['pending', 'completed'])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
