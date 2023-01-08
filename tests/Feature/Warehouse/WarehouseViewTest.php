<?php

namespace Tests\Feature\Warehouse;

use App\Models\User;
use App\Models\Warehouse;
use Tests\TestCase;

class WarehouseViewTest extends TestCase
{
    /**
     * @test
     * Test if the Livewire warehouse component can be accessed and seen.
     */
    public function can_access_and_see_warehouse_component()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $this->get(route('warehouse.index'))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.warehouse.index-view');

        $this->get(route('warehouse.show', Warehouse::where('name', 'Warehouse Keeper')->first()->id))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.warehouse.show-view');
    }

    /**
     * @test
     * Test if the Livewire warehouse operation create can be accessed and seen.
     */
    public function can_access_and_see_warehouse_create_component()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $this->get(route('warehouse.create'))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.warehouse.create-view');

        $this->get(route('warehouse.create.storage', Warehouse::where('name', 'Warehouse Keeper')->first()->id))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.warehouse.create-storage-view');

        $this->get(route('warehouse.create.summary', Warehouse::where('name', 'Warehouse Keeper')->first()->id))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.warehouse.create-summary-view');
    }

    /**
     * @test
     * Test if the Livewire warehouse action can be accessed and seen.
     */
    public function can_access_and_see_warehouse_delete_update_component()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $this->get(route('warehouse.destroy', Warehouse::where('name', 'Warehouse Keeper')->first()->id))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.warehouse.destroy-view');

        $this->get(route('warehouse.edit', Warehouse::where('name', 'Warehouse Keeper')->first()->id))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.warehouse.edit-view');
    }
}
