<?php

namespace Tests\Feature\Employee;

use App\Http\Livewire\Feature\Employee\CreateView;
use App\Http\Livewire\Feature\Employee\EditView;
use App\Http\Livewire\Feature\Employee\DestroyView;
use App\Models\Employee;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Warehouse;
use Livewire\Livewire;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    /**
     * @test
     * Test if the create employee flow can store a data.
     */
    public function can_create_new_employee()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $user = User::inRandomOrder()->first();
        $warehouse = Warehouse::inRandomOrder()->first();

        $test = Livewire::test(CreateView::class);
        $test->set('selected_user', $user)
            ->set('selected_warehouse', $warehouse)
            ->set('role_id', UserRole::where('name', 'Employee')->first()->id)
            ->call('store');

        $employee = Employee::where('user_id', $user->id)->where('warehouse_id', $warehouse->id)->first();
        $employee_exist = $employee != null;

        $test->assertHasNoErrors(['selected_user', 'selected_warehouse']);
        $this->assertTrue($employee_exist);
    }

    /**
     * @test
     * Test if the employee flow can update a data.
     */
    public function can_update_employee_data()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $employee = Employee::latest()->first();
        $warehouse = Warehouse::latest()->first();

        $test = Livewire::test(EditView::class, ['employee_id' => $employee->id]);
        $test->set('first_name', 'Employee')
            ->set('last_name', 'Test')
            ->set('email', 'employee@test.com')
            ->set('phone_number', '62123456789')
            ->set('warehouse_id', $warehouse->id)
            ->set('user_role_id', UserRole::where('name', 'Employee')->first()->id)
            ->set('status', 1)
            ->call('update');

        $employee = Employee::find($employee->id);

        $test->assertHasNoErrors(['first_name', 'last_name', 'email', 'phone_number', 'warehouse_id', 'user_role_id', 'status']);
        $this->assertTrue($employee != null);
        $test->assertRedirect(route('employee.show', $employee->id));
    }

    /**
     * @test
     * Test if the employee flow can delete a data.
     */
    public function can_delete_employee_data()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $employee = Employee::latest()->first();

        $test = Livewire::test(DestroyView::class, ['employee_id' => $employee->id]);
        $test->call('destroy');

        $employee = Employee::find($employee->id);

        $this->assertTrue($employee == null);
        $test->assertRedirect(route('employee.index'));
    }
}
