<?php

namespace Tests\Feature\Employee;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeViewTest extends TestCase
{
    /**
     * @test
     * Test if the Livewire employee component can be accessed and seen.
     */
    public function can_access_and_see_employee_component()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $this->get(route('employee.index'))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.employee.index-view');

        $this->get(route('employee.show', Employee::where('user_id', User::where('email', 'employee@keeper.com')->first()->id)->first()->id))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.employee.show-view');
    }

    /**
     * @test
     * Test if the Livewire employee operation create can be accessed and seen.
     */
    public function can_access_and_see_employee_create_component()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $this->get(route('employee.create'))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.employee.create-view');
    }

    /**
     * @test
     * Test if the Livewire employee action can be accessed and seen.
     */
    public function can_access_and_see_employee_delete_update_component()
    {
        $this->actingAs(User::where('email', 'superadmin@keeper.com')->first());

        $this->get(route('employee.destroy', Employee::where('user_id', User::where('email', 'employee@keeper.com')->first()->id)->first()->id))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.employee.destroy-view');

        $this->get(route('employee.edit', Employee::where('user_id', User::where('email', 'employee@keeper.com')->first()->id)->first()->id))
            ->assertSuccessful()
            ->assertSeeLivewire('feature.employee.edit-view');
    }
}
