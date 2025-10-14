<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(State::class)->nullable();
            $table->foreignIdFor(City::class)->nullable();
            $table->foreignIdFor(Area::class)->nullable();
            $table->string('address')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('alternate_mobile')->nullable();
            $table->json('avtar')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
