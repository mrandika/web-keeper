<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'user_id' => User::where('email', 'superadmin@keeper.com')->first()->id,
            'warehouse_id' => Warehouse::where('name', 'Warehouse Keeper')->first()->id,
            'status' => 1
        ]);

        Employee::create([
            'user_id' => User::where('email', 'admin@keeper.com')->first()->id,
            'warehouse_id' => Warehouse::where('name', 'Warehouse Keeper')->first()->id,
            'status' => 1
        ]);

        Employee::create([
            'user_id' => User::where('email', 'employee@keeper.com')->first()->id,
            'warehouse_id' => Warehouse::where('name', 'Warehouse Keeper')->first()->id,
            'status' => 1
        ]);
    }
}
