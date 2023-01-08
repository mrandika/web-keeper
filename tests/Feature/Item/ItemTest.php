<?php

namespace Tests\Feature\Item;

use App\Http\Livewire\Feature\Item\CreateView;
use App\Http\Livewire\Feature\Item\DestroyView;
use App\Http\Livewire\Feature\Item\EditView;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ItemTest extends TestCase
{
    /**
     * @test
     * Test if the create item flow can store a data.
     */
    public function can_create_new_item()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $test = Livewire::test(CreateView::class);
        $test->set('name', 'Product Test')
            ->set('sku', 'Test-SKU01')
            ->set('price', '10000')
            ->call('store');

        $item = Item::where('name', 'Product Test')->first();
        $item_exist = $item != null;

        $test->assertHasNoErrors(['name', 'sku', 'price']);
        $this->assertTrue($item_exist);
    }

    /**
     * @test
     * Test if the item flow can update a data.
     */
    public function can_update_item_data()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());
        $item = Item::where('name', 'Product Test')->first();

        $test = Livewire::test(EditView::class, ['item_id' => $item->id]);
        $test->set('name', 'Product Test Update')
            ->set('sku', 'Test-SKU01 UP')
            ->set('price', '10001')
            ->call('update');

        $item = Item::where('name', 'Product Test Update')->first();

        $test->assertHasNoErrors(['name', 'sku', 'price']);
        $this->assertTrue($item != null);
        $test->assertRedirect(route('item.show', $item->id));
    }

    /**
     * @test
     * Test if the item flow can delete a data.
     */
    public function can_delete_item_data()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());
        $item = Item::where('name', 'Product Test Update')->first();

        $test = Livewire::test(DestroyView::class, ['item_id' => $item->id]);
        $test->call('destroy');

        $item = Item::where('name', 'Product Test Update')->first();

        $test->assertHasNoErrors(['name', 'sku', 'price']);
        $this->assertTrue($item == null);
        $test->assertRedirect(route('item.index'));
    }
}
