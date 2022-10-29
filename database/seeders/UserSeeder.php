<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'superadmin@keeper.com',
            'password' => Hash::make('Supersecret@123'),
            'user_role_id' => UserRole::where('name', 'Super-Admin')->first()->id
        ]);

        User::create([
            'email' => 'admin@keeper.com',
            'password' => Hash::make('Supersecret@123'),
            'user_role_id' => UserRole::where('name', 'Admin')->first()->id
        ]);

        User::create([
            'email' => 'employee@keeper.com',
            'password' => Hash::make('Supersecret@123'),
            'user_role_id' => UserRole::where('name', 'Employee')->first()->id
        ]);
    }
}
