<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Warehouse::create([
            'name' => 'Warehouse Keeper',
            'address' => 'Jalan Telekomunikasi 1',
            'latitude' => -6.973260519819465,
            'longitude' => 107.63178025110288
        ]);
    }
}
