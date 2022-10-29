<?php

namespace Database\Seeders;

use App\Models\WarehouseAisle;
use App\Models\WarehouseAisleColumn;
use App\Models\WarehouseAisleRow;
use App\Models\WarehouseStorage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseStorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 4; $i++) {
            for ($j = 1; $j <= 2; $j++) {
                for ($k = 1; $k <= 5; $k++) {
                    WarehouseStorage::create([
                        'warehouse_aisle_id' => WarehouseAisle::where('code', 'KEEPER-A0'.$i)->first()->id,
                        'warehouse_aisle_column_id' => WarehouseAisleColumn::where('code', 'A0'.$i.'-B'.$j)->first()->id,
                        'warehouse_aisle_row_id' => WarehouseAisleRow::where('code', 'A0'.$i.'-B'.$j.'_C0'.$k)->first()->id
                    ]);
                }
            }
        }
    }
}
