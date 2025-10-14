<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StaffPermission;    

class StaffPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StaffPermission::create([
            'name' => 'add',
        ]);
        StaffPermission::create([
            'name' => 'edit',
        ]);
        StaffPermission::create([
            'name' => 'view',
        ]);
        StaffPermission::create([
            'name' => 'delete',
        ]);
    }
}
