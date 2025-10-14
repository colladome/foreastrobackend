<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Hariom',
            'email' => 'hariompandeyp0@gmail.com',
            'mobile_number' => '7388439878',
            'user_type' => 'admin',
            'password' => Hash::make('admin@12345'),
            'status' => '1'
        ]);
    }
}
