<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'user_id' => User::where('email', 'superadmin@keeper.com')->first()->id,
            'status' => 1
        ]);

        Admin::create([
            'user_id' => User::where('email', 'admin@keeper.com')->first()->id,
            'status' => 1
        ]);
    }
}
