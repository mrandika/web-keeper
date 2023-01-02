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
            'name' => 'Gas LPG 12KG',
            'sku' => 'LPG-12-123456789',
            'price' => 80000
        ]);

        Item::create([
            'name' => 'Gas LPG 3KG ',
            'sku' => 'LPG-3-123456789',
            'price' => 25000
        ]);

        Item::create([
            'name' => 'Tabung Oksigen 6m3',
            'sku' => 'OXY-6M3-123456789',
            'price' => 1500000
        ]);

        Item::create([
            'name' => 'Trolley Sedang',
            'sku' => 'TRO-M-123456789',
            'price' => 50000
        ]);

        Item::create([
            'name' => 'Trolley Besar',
            'sku' => 'TRO-B-123456789',
            'price' => 100000
        ]);
    }
}
