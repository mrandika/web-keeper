<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemLocation;
use App\Models\WarehouseAisle;
use App\Models\WarehouseAisleColumn;
use App\Models\WarehouseAisleRow;
use App\Models\WarehouseStorage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ItemLocation::create([
            'item_id' => Item::where('sku', 'A-A01-B1_C01')->first()->id,
            'warehouse_storage_id' => WarehouseStorage::where([
                'warehouse_aisle_id' => WarehouseAisle::where('code', 'KEEPER-A01')->first()->id,
                'warehouse_aisle_column_id' => WarehouseAisleColumn::where('code', 'A01-B1')->first()->id,
                'warehouse_aisle_row_id' => WarehouseAisleRow::where('code', 'A01-B1_C01')->first()->id,
            ])->first()->id
        ]);
    }
}
