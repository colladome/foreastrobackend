<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Backend\Category;
use App\Models\Backend\State;
use App\Models\Backend\City;
use App\Models\Backend\Area;
use App\Models\User;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendor_category_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Category::class);
            $table->foreignIdFor(State::class);
            $table->foreignIdFor(City::class);
            $table->foreignIdFor(Area::class);
            $table->string('business_profile_name');
            $table->string('contact_number')->nullable();
            $table->string('address');
            $table->string('pin_code');
            $table->string('location_link')->nullable();
            $table->json('listing_cover_image');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_category_profiles');
    }
};
