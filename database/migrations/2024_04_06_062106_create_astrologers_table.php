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
        Schema::create('astrologers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();;
            $table->string('email')->unique()->nullable();;
            $table->string('mobile_number')->unique();
            $table->string('gender')->nullable();
            $table->string('adhar_id')->unique()->nullable();
            $table->string('pan_number')->unique()->nullable();
            $table->string('specialization')->nullable();
            $table->json('languaage')->nullable();
            $table->enum('user_type', ['astro']);
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('profile_img')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('gauth_id')->nullable();
            $table->string('gauth_type')->nullable();
            $table->enum('is_profile_created', ['0', '1'])->default('0')->comment('is_profile_created: created =>1 and not created =>0');
            $table->string('password')->nullable();
            $table->enum('status', ['0', '1'])->default('1')->comment('Status: active =>1 and inactive =>0');
            $table->string('profile_status')->nullable();
            $table->string('trusted')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('experience')->nullable();
            $table->string('call_charges_per_min')->nullable();
            $table->string('chat_charges_per_min')->nullable();
            $table->string('video_charges_per_min')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('education')->nullable();
            $table->string('commission_percent')->nullable();
            $table->string('commission_descreption')->nullable();
            $table->string('notifaction_token')->nullable();
            $table->longText('description')->nullable();
            $table->longText('start_time_slot')->nullable();
            $table->longText('end_time_slot')->nullable();
            $table->string('total_rating')->nullable();
            $table->string('wallet')->default(0);
            $table->timestamp('expire_at')->nullable()->comment('is astrologer online');
            $table->enum('is_onboarding_completed', ['0', '1'])->default(0);
            $table->timestamp('boosted_at');
            $table->timestamp('boost_expire_at');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('astrologers');
    }
};
