<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Vendor\VendorBusinessCategoryDetail;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendor_venue_spaces', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(VendorBusinessCategoryDetail::class);
            $table->string('space_name')->nullable();
            $table->json('venue_suitable')->nullable();
            $table->string('seating_pax')->nullable();
            $table->string('venu_type')->nullable();
            $table->string('venue_rent')->nullable();
            $table->enum('lawn_availability', ['yes','no'])->default('no');
            $table->enum('parking_availability', ['yes','no'])->default('no');
            $table->enum('ac_availability', ['yes','no'])->default('no');
            $table->enum('inside_alcohol_permission', ['yes','no'])->default('no');
            $table->enum('permission_to_acquire_outside_alchohol', ['yes','no'])->default('no');
            $table->enum('alcohol_allowed', ['yes','no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_venue_spaces');
    }
};
