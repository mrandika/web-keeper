<?php

namespace Database\Seeders;

use App\Models\WarehouseAisleColumn;
use App\Models\WarehouseAisleRow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseAisleRowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            WarehouseAisleRow::create([
                'code' => 'A01-B1_C0'.$i,
                'warehouse_aisle_column_id' => WarehouseAisleColumn::where('code', 'A01-B1')->first()->id
            ]);

            WarehouseAisleRow::create([
                'code' => 'A01-B2_C0'.$i,
                'warehouse_aisle_column_id' => WarehouseAisleColumn::where('code', 'A01-B2')->first()->id
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            WarehouseAisleRow::create([
                'code' => 'A02-B1_C0'.$i,
                'warehouse_aisle_column_id' => WarehouseAisleColumn::where('code', 'A02-B1')->first()->id
            ]);

            WarehouseAisleRow::create([
                'code' => 'A02-B2_C0'.$i,
                'warehouse_aisle_column_id' => WarehouseAisleColumn::where('code', 'A02-B2')->first()->id
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            WarehouseAisleRow::create([
                'code' => 'A03-B1_C0'.$i,
                'warehouse_aisle_column_id' => WarehouseAisleColumn::where('code', 'A03-B1')->first()->id
            ]);

            WarehouseAisleRow::create([
                'code' => 'A03-B2_C0'.$i,
                'warehouse_aisle_column_id' => WarehouseAisleColumn::where('code', 'A03-B2')->first()->id
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            WarehouseAisleRow::create([
                'code' => 'A04-B1_C0'.$i,
                'warehouse_aisle_column_id' => WarehouseAisleColumn::where('code', 'A04-B1')->first()->id
            ]);

            WarehouseAisleRow::create([
                'code' => 'A04-B2_C0'.$i,
                'warehouse_aisle_column_id' => WarehouseAisleColumn::where('code', 'A04-B2')->first()->id
            ]);
        }
    }
}
