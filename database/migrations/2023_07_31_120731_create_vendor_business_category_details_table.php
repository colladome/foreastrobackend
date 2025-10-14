<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Backend\Category;
use App\Models\Vendor\VendorCategoryProfile;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendor_business_category_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Category::class);
            $table->foreignIdFor(VendorCategoryProfile::class);
            $table->json('venue_criteria')->nullable();
            $table->string('number_of_room_available')->nullable();
            $table->string('maximum_capacity')->nullable();
            $table->json('cuisine_type')->nullable();
            $table->enum('parking_availability_detial', ['yes', 'no'])->default('no');
            $table->enum('ac_availability_detial', ['yes', 'no'])->default('no');
            $table->enum('alcohol_allowed_detial', ['yes', 'no'])->default('no');
            $table->enum('is_photography', ['yes', 'no'])->nullable();
            $table->enum('is_videography', ['yes', 'no'])->nullable();
            $table->enum('is_your_venue_pure_vegetarian_detial', ['yes', 'no'])->default('no');
            $table->enum('inhouse_catering_only_detial', ['yes', 'no'])->default('no');
            $table->string('per_plate_veg_price')->nullable();
            $table->string('per_plate_non_veg_price')->nullable();
            $table->string('min_price')->nullable();
            $table->enum('is_trial_makeup', ['yes', 'no'])->nullable();
            $table->enum('is_trial_makeup_free', ['yes', 'no'])->nullable();
            $table->string('makeup_trail_price')->nullable();
            $table->string('bride_makeup_price')->nullable();
            $table->string('family_makeup_price')->nullable();
            $table->string('groom_makeup_price')->nullable();
            $table->string('makeup_description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_business_category_details');
    }
};
