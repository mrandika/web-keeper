<?php

namespace Tests\Feature\Warehouse;

use App\Http\Livewire\Feature\Warehouse\CreateStorageView;
use App\Models\User;
use App\Models\Warehouse;
use Livewire\Livewire;
use Tests\TestCase;

class WarehouseStorageValidatorTest extends TestCase
{
    /**
     * @test
     * Test if the component throws error if warehouse storage code has valid input.
     */
    public function check_code_validation()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());
        $warehouse = Warehouse::where('name', 'Warehouse Keeper')->first();

        $test = Livewire::test(CreateStorageView::class, ['warehouse_id' => $warehouse->id]);

        // Missing code
        $test->set('code', '')
            ->call('save_storage')
            ->assertHasErrors(['code' => 'required']);

        // Invalid length
        $test->set('code', 'a')
            ->call('save_storage')
            ->assertHasErrors(['code' => 'min:2']);

        $test->set('code', 'abcdefg')
            ->call('save_storage')
            ->assertHasErrors(['code' => 'max:6']);
    }

    /**
     * @test
     * Test if the component throws error if warehouse storage aisle has valid input.
     */
    public function check_aisle_validation()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());
        $warehouse = Warehouse::where('name', 'Warehouse Keeper')->first();

        $test = Livewire::test(CreateStorageView::class, ['warehouse_id' => $warehouse->id]);

        // Missing code
        $test->set('aisle', '')
            ->call('save_storage')
            ->assertHasErrors(['aisle' => 'required']);

        // Non-numeric value
        $test->set('aisle', 'abc')
            ->call('save_storage')
            ->assertHasErrors(['aisle' => 'numeric']);

        // Invalid value
        $test->set('aisle', '-1')
            ->call('save_storage')
            ->assertHasErrors(['aisle' => 'between:1,5']);

        $test->set('aisle', '0')
            ->call('save_storage')
            ->assertHasErrors(['aisle' => 'between:1,5']);

        $test->set('aisle', '999')
            ->call('save_storage')
            ->assertHasErrors(['aisle' => 'between:1,5']);
    }

    /**
     * @test
     * Test if the component throws error if warehouse storage column has valid input.
     */
    public function check_column_validation()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());
        $warehouse = Warehouse::where('name', 'Warehouse Keeper')->first();

        $test = Livewire::test(CreateStorageView::class, ['warehouse_id' => $warehouse->id]);

        // Missing code
        $test->set('column', '')
            ->call('save_storage')
            ->assertHasErrors(['column' => 'required']);

        // Non-numeric value
        $test->set('column', 'abc')
            ->call('save_storage')
            ->assertHasErrors(['column' => 'numeric']);

        // Invalid value
        $test->set('column', '-1')
            ->call('save_storage')
            ->assertHasErrors(['column' => 'between:1,5']);

        $test->set('column', '0')
            ->call('save_storage')
            ->assertHasErrors(['column' => 'between:1,5']);

        $test->set('column', '999')
            ->call('save_storage')
            ->assertHasErrors(['column' => 'between:1,5']);
    }

    /**
     * @test
     * Test if the component throws error if warehouse storage row has valid input.
     */
    public function check_row_validation()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());
        $warehouse = Warehouse::where('name', 'Warehouse Keeper')->first();

        $test = Livewire::test(CreateStorageView::class, ['warehouse_id' => $warehouse->id]);

        // Missing code
        $test->set('row', '')
            ->call('save_storage')
            ->assertHasErrors(['row' => 'required']);

        // Non-numeric value
        $test->set('row', 'abc')
            ->call('save_storage')
            ->assertHasErrors(['row' => 'numeric']);

        // Invalid value
        $test->set('row', '-1')
            ->call('save_storage')
            ->assertHasErrors(['row' => 'between:1,5']);

        $test->set('column', '0')
            ->call('save_storage')
            ->assertHasErrors(['row' => 'between:1,5']);

        $test->set('row', '999')
            ->call('save_storage')
            ->assertHasErrors(['row' => 'between:1,5']);
    }
}
