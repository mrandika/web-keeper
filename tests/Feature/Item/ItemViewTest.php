<?php

namespace Tests\Feature\Item;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemViewTest extends TestCase
{
    /**
     * @test
     * Test if the Livewire item component can be accessed and seen.
     */
    public function can_access_and_see_item_component()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $this->get(route('item.index'))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.item.index-view');

        $this->get(route('item.show', Item::where('name', 'Product A')->first()->id))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.item.show-view');
    }

    /**
     * @test
     * Test if the Livewire item operation create can be accessed and seen.
     */
    public function can_access_and_see_item_create_component()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $this->get(route('item.create'))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.item.create-view');
    }

    /**
     * @test
     * Test if the Livewire item action can be accessed and seen.
     */
    public function can_access_and_see_item_delete_update_component()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $this->get(route('item.destroy', Item::where('name', 'Product A')->first()->id))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.item.destroy-view');

        $this->get(route('item.edit', Item::where('name', 'Product A')->first()->id))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.item.edit-view');
    }
}
