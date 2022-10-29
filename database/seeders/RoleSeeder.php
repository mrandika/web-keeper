<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::create([
            'name' => 'Super-Admin'
        ]);

        UserRole::create([
            'name' => 'Admin'
        ]);

        UserRole::create([
            'name' => 'Employee'
        ]);
    }
}
