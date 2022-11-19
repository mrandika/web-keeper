<?php

namespace Tests\Feature\Warehouse;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
            ->assertSeeLivewire('warehouse.index-view');

        $this->get(route('warehouse.show', Warehouse::where('name', 'Warehouse Keeper')->first()->id))
            ->assertSuccessful()
            ->assertSeeLivewire('warehouse.show-view');
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
            ->assertSeeLivewire('warehouse.create-view');

        $this->get(route('warehouse.create.storage', Warehouse::where('name', 'Warehouse Keeper')->first()->id))
            ->assertSuccessful()
            ->assertSeeLivewire('warehouse.create-storage-view');

        $this->get(route('warehouse.create.summary', Warehouse::where('name', 'Warehouse Keeper')->first()->id))
            ->assertSuccessful()
            ->assertSeeLivewire('warehouse.create-summary-view');
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
            ->assertSeeLivewire('warehouse.destroy-view');

        $this->get(route('warehouse.edit', Warehouse::where('name', 'Warehouse Keeper')->first()->id))
            ->assertSuccessful()
            ->assertSeeLivewire('warehouse.edit-view');
    }
}
