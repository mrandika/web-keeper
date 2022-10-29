<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\UserData;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class
        ]);

        User::factory()->count(10)->create()->each(function ($user) {
            UserData::factory()->create(['user_id' => $user->id]);
        });

        $this->call([
            UserSeeder::class,
            UserDataSeeder::class,
            AdminSeeder::class,
            WarehouseSeeder::class,
            WarehouseAisleSeeder::class,
            WarehouseAisleColumnSeeder::class,
            WarehouseAisleRowSeeder::class,
            WarehouseStorageSeeder::class,
            ItemSeeder::class,
            ItemLocationSeeder::class
        ]);
    }
}
