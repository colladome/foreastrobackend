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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();;
            $table->string('email')->unique()->nullable();;
            $table->string('mobile_number')->unique();
            $table->string('gender')->nullable();
            $table->enum('user_type', ['admin', 'user', 'staff']);
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('birth_time')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('profile_img')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('gauth_id')->nullable();
            $table->string('gauth_type')->nullable();
            $table->string('is_online')->nullable();
            $table->string('sign')->nullable();
            $table->string('wallet')->nullable();
            $table->string('notifaction_token')->nullable();

            $table->enum('is_profile_created', ['0', '1'])->default('0')->comment('is_profile_created: created =>1 and not created =>0');
            $table->string('password')->nullable();
            $table->enum('status', ['0', '1'])->default('1')->comment('Status: active =>1 and inactive =>0');
            $table->timestamp('expire_at')->nullable()->comment('is user online');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
