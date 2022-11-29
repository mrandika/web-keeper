<?php

namespace Tests\Feature\Item;

use App\Http\Livewire\Feature\Item\CreateView;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ItemValidatorTest extends TestCase
{
    /**
     * @test
     * Test if the component throws error if item name has invalid input.
     */
    public function check_name_validation()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $test = Livewire::test(CreateView::class);

        // Missing email
        $test->set('name', '')
            ->call('store')
            ->assertHasErrors(['name' => 'required']);

        // Invalid length
        $test->set('name', 'a')
            ->call('store')
            ->assertHasErrors(['name' => 'min:5']);

        $test->set('name', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin at dictum augue. Donec pharetra eros a velit bibendum iaculis. Ut mauris velit, porttitor ut cursus eget, scelerisque ac leo.')
            ->call('store')
            ->assertHasErrors(['name' => 'max:75']);
    }

    /**
     * @test
     * Test if the component throws error if item sku has invalid input.
     */
    public function check_sku_validation()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $test = Livewire::test(CreateView::class);

        // Missing email
        $test->set('sku', '')
            ->call('store')
            ->assertHasErrors(['sku' => 'required']);

        // Invalid length
        $test->set('sku', 'a')
            ->call('store')
            ->assertHasErrors(['sku' => 'min:2']);

        $test->set('sku', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin at dictum augue. Donec pharetra eros a velit bibendum iaculis. Ut mauris velit, porttitor ut cursus eget, scelerisque ac leo.')
            ->call('store')
            ->assertHasErrors(['sku' => 'max:25']);
    }

    /**
     * @test
     * Test if the component throws error if item price has invalid input.
     */
    public function check_price_validation()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $test = Livewire::test(CreateView::class);

        // Missing email
        $test->set('price', '')
            ->call('store')
            ->assertHasErrors(['price' => 'required']);

        // Non-numeric value
        $test->set('price', 'abc')
            ->call('store')
            ->assertHasErrors(['price' => 'numeric']);
    }
}
