<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Backend\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendor_business_category_abouts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Category::class);
            $table->longText('about_section')->nullable();
            $table->enum('is_price_negotiable', ['yes','no'])->default('no');
            $table->longText('usp_feature')->nullable();
            $table->longText('award_and_recognition')->nullable();
            $table->longText('payment_policy')->nullable();
            $table->longText('cancellation_policy')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_business_category_abouts');
    }
};
