<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use App\Models\WarehouseAisle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseAisleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WarehouseAisle::create([
            'warehouse_id' => Warehouse::where('name', 'Warehouse Keeper')->first()->id,
            'code' => 'KEEPER-A01',
        ]);

        WarehouseAisle::create([
            'warehouse_id' => Warehouse::where('name', 'Warehouse Keeper')->first()->id,
            'code' => 'KEEPER-A02',
        ]);

        WarehouseAisle::create([
            'warehouse_id' => Warehouse::where('name', 'Warehouse Keeper')->first()->id,
            'code' => 'KEEPER-A03',
        ]);

        WarehouseAisle::create([
            'warehouse_id' => Warehouse::where('name', 'Warehouse Keeper')->first()->id,
            'code' => 'KEEPER-A04',
        ]);

        WarehouseAisle::create([
            'warehouse_id' => Warehouse::where('name', 'Warehouse Telkom')->first()->id,
            'code' => 'TELKOM-Y01',
        ]);

        WarehouseAisle::create([
            'warehouse_id' => Warehouse::where('name', 'Warehouse Telkom')->first()->id,
            'code' => 'TELKOM-Y02',
        ]);

        WarehouseAisle::create([
            'warehouse_id' => Warehouse::where('name', 'Warehouse Telkom')->first()->id,
            'code' => 'TELKOM-Y03',
        ]);

        WarehouseAisle::create([
            'warehouse_id' => Warehouse::where('name', 'Warehouse Telkom')->first()->id,
            'code' => 'TELKOM-Y04',
        ]);
    }
}
