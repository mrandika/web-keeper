<?php

namespace Tests\Feature\Warehouse;

use App\Http\Livewire\Feature\Warehouse\CreateView;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class WarehouseValidatorTest extends TestCase
{
    /**
     * @test
     * Test if the component throws error if warehouse name has valid input.
     */
    public function check_name_validation()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $test = Livewire::test(CreateView::class);

        // Missing email
        $test->set('warehouse.name', '')
            ->call('save_basic')
            ->assertHasErrors(['warehouse.name' => 'required']);

        // Invalid length
        $test->set('warehouse.name', 'a')
            ->call('save_basic')
            ->assertHasErrors(['warehouse.name' => 'min:10']);

        $test->set('warehouse.name', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin at dictum augue. Donec pharetra eros a velit bibendum iaculis. Ut mauris velit, porttitor ut cursus eget, scelerisque ac leo.')
            ->call('save_basic')
            ->assertHasErrors(['warehouse.name' => 'max:75']);
    }

    /**
     * @test
     * Test if the component throws error if warehouse address has valid input.
     */
    public function check_address_validation()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $test = Livewire::test(CreateView::class);

        // Missing email
        $test->set('warehouse.address', '')
            ->call('save_basic')
            ->assertHasErrors(['warehouse.address' => 'required']);
    }

    /**
     * @test
     * Test if the component throws error if warehouse latitude has valid input.
     */
    public function check_latitude_validation()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $test = Livewire::test(CreateView::class);

        // Missing email
        $test->set('warehouse.latitude', '')
            ->call('save_basic')
            ->assertHasErrors(['warehouse.latitude' => 'required']);
    }

    /**
     * @test
     * Test if the component throws error if warehouse longitude has valid input.
     */
    public function check_longitude_validation()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $test = Livewire::test(CreateView::class);

        // Missing email
        $test->set('warehouse.latitude', '')
            ->call('save_basic')
            ->assertHasErrors(['warehouse.latitude' => 'required']);
    }
}
