<?php

namespace Database\Seeders;

use App\Models\WarehouseAisle;
use App\Models\WarehouseAisleColumn;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseAisleColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WarehouseAisleColumn::create([
            'code' => 'A01-B1',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'KEEPER-A01')->first()->id
        ]);

        WarehouseAisleColumn::create([
            'code' => 'A01-B2',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'KEEPER-A01')->first()->id
        ]);

        WarehouseAisleColumn::create([
            'code' => 'A02-B1',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'KEEPER-A02')->first()->id
        ]);

        WarehouseAisleColumn::create([
            'code' => 'A02-B2',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'KEEPER-A02')->first()->id
        ]);

        WarehouseAisleColumn::create([
            'code' => 'A03-B1',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'KEEPER-A03')->first()->id
        ]);

        WarehouseAisleColumn::create([
            'code' => 'A03-B2',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'KEEPER-A03')->first()->id
        ]);

        WarehouseAisleColumn::create([
            'code' => 'A04-B1',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'KEEPER-A04')->first()->id
        ]);

        WarehouseAisleColumn::create([
            'code' => 'A04-B2',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'KEEPER-A04')->first()->id
        ]);

        WarehouseAisleColumn::create([
            'code' => 'Y01-Z1',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'TELKOM-Y01')->first()->id
        ]);

        WarehouseAisleColumn::create([
            'code' => 'Y01-Z2',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'TELKOM-Y01')->first()->id
        ]);

        WarehouseAisleColumn::create([
            'code' => 'Y02-Z1',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'TELKOM-Y02')->first()->id
        ]);

        WarehouseAisleColumn::create([
            'code' => 'Y02-Z2',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'TELKOM-Y02')->first()->id
        ]);

        WarehouseAisleColumn::create([
            'code' => 'Y03-Z1',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'TELKOM-Y03')->first()->id
        ]);

        WarehouseAisleColumn::create([
            'code' => 'Y03-Z2',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'TELKOM-Y03')->first()->id
        ]);

        WarehouseAisleColumn::create([
            'code' => 'Y04-Z1',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'TELKOM-Y04')->first()->id
        ]);

        WarehouseAisleColumn::create([
            'code' => 'Y04-Z2',
            'warehouse_aisle_id' => WarehouseAisle::where('code', 'TELKOM-Y04')->first()->id
        ]);
    }
}
