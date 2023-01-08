<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserData::create([
            'user_id' => User::where('email', 'superadmin@keeper.com')->first()->id,
            'first_name' => 'Super-Admin',
            'last_name' => 'Keeper',
            'phone_number' => '+62123456789'
        ]);

        UserData::create([
            'user_id' => User::where('email', 'admin@keeper.com')->first()->id,
            'first_name' => 'Admin',
            'last_name' => 'Keeper',
            'phone_number' => '+62987654321'
        ]);

        UserData::create([
            'user_id' => User::where('email', 'employee@keeper.com')->first()->id,
            'first_name' => 'Employee',
            'last_name' => 'Keeper',
            'phone_number' => '+625647382910'
        ]);

        UserData::create([
            'user_id' => User::where('email', 'admin@telkom.com')->first()->id,
            'first_name' => 'Admin',
            'last_name' => 'Telkom',
            'phone_number' => '+62987654322'
        ]);

        UserData::create([
            'user_id' => User::where('email', 'employee@telkom.com')->first()->id,
            'first_name' => 'Employee',
            'last_name' => 'Telkom',
            'phone_number' => '+625647382911'
        ]);
    }
}
