<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::create([
            'warehouse_id' => Warehouse::where('name', 'Warehouse Keeper')->first()->id,
            'name' => 'Product A',
            'sku' => 'A-A01-B1_C01',
            'stock' => 100,
            'price' => 1000
        ]);
    }
}
