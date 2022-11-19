<?php

namespace Tests\Feature\Warehouse;

use App\Http\Livewire\Warehouse\CreateStorageView;
use App\Http\Livewire\Warehouse\CreateView;
use App\Http\Livewire\Warehouse\DestroyView;
use App\Http\Livewire\Warehouse\EditView;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class WarehouseTest extends TestCase
{
    /**
     * @test
     * Test if the create warehouse flow can store a data.
     */
    public function can_create_new_warehouse()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $test = Livewire::test(CreateView::class);
        $test->set('warehouse.name', 'Warehouse Test')
            ->set('warehouse.address', 'Jalan Test')
            ->set('warehouse.latitude', '0')
            ->set('warehouse.longitude', '0')
            ->call('save_basic');

        $warehouse = Warehouse::where('name', 'Warehouse Test')->first();
        $warehouse_exist = $warehouse != null;

        $test->assertHasNoErrors(['warehouse.name', 'warehouse.address', 'warehouse.latitude', 'warehouse.longitude']);
        $this->assertTrue($warehouse_exist);
    }

    /**
     * @test
     * Test if the create warehouse flow can store a storage data.
     */
    public function can_create_new_warehouse_storage()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());
        $warehouse = Warehouse::where('name', 'Warehouse Test')->first();

        $aisle = 4;
        $column = 5;
        $row = 4;

        $test = Livewire::test(CreateStorageView::class, ['warehouse_id' => $warehouse->id]);
        $test->set('code', 'TEST')
            ->set('aisle', $aisle)
            ->set('column', $column)
            ->set('row', $row)
            ->call('save_storage');

        $test->assertHasNoErrors(['code', 'aisle', 'column', 'row']);
        $this->assertTrue($warehouse->storages->count() == ($column * $row) * $aisle);
    }

    /**
     * @test
     * Test if the create warehouse flow can update a data.
     */
    public function can_update_warehouse_data()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());
        $warehouse = Warehouse::where('name', 'Warehouse Test')->first();

        $test = Livewire::test(EditView::class, ['warehouse_id' => $warehouse->id]);
        $test->set('name', 'Warehouse Test Update')
            ->set('address', 'Jalan Test Update')
            ->set('latitude', '1')
            ->set('longitude', '1')
            ->call('update');

        $warehouse = Warehouse::where('name', 'Warehouse Test Update')->first();

        $test->assertHasNoErrors(['name', 'address', 'latitude', 'longitude']);
        $this->assertTrue($warehouse != null);
        $test->assertRedirect(route('warehouse.show', $warehouse->id));
    }

    /**
     * @test
     * Test if the create warehouse flow can delete a data.
     */
    public function can_delete_warehouse_data()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());
        $warehouse = Warehouse::where('name', 'Warehouse Test Update')->first();

        $test = Livewire::test(DestroyView::class, ['warehouse_id' => $warehouse->id]);
        $test->call('destroy');

        $warehouse = Warehouse::where('name', 'Warehouse Test Update')->first();

        $test->assertHasNoErrors(['name', 'address', 'latitude', 'longitude']);
        $this->assertTrue($warehouse == null);
        $test->assertRedirect(route('warehouse.index'));
    }
}
