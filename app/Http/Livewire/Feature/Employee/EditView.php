<?php

namespace App\Http\Livewire\Feature\Employee;

use App\Models\Employee;
use App\Models\User;
use App\Models\UserData;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class EditView extends Component
{
    public $employee, $employee_id;
    public $email, $phone_number;
    public $first_name, $last_name;
    public $selected_warehouse, $warehouse_id;
    public $user_role_id, $status;

    /**
     * Mount the Livewire component
     * Mounting the component will ONLY set the data once, even the view is refreshed/rerendered.
     *
     * @param $employee_id
     * @return void
     */
    public function mount($employee_id)
    {
        $this->employee_id = $employee_id;
    }

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        $user = Auth::user();

        try {
            $this->employee = Employee::findOrFail($this->employee_id);
        } catch (ModelNotFoundException $e) {
            $this->redirect_page('error');
        }

        if ($user->role->name == 'Super-Admin') {
            $warehouses = Warehouse::where('user_id', $user->id)->get();
        } else {
            $warehouses = Warehouse::whereIn('id', $user->employees->pluck('warehouse_id')->toArray())->get();
        }

        return view('livewire.feature.employee.edit-view', ['employee' => $this->employee, 'warehouses' => $warehouses])
            ->extends('layouts.dashboard')
            ->section('main');
    }

    /**
     * Redirect to specified route name
     *
     * @param string $route_name    The route name declared on routing file
     * @param $param                The data sent to specified $route_name, default is null
     *
     * @return RedirectResponse
     */
    public function redirect_page(string $route_name, $param = null)
    {
        if (isset($param)) {
            return redirect()->route($route_name, $param);
        } else {
            return redirect()->route($route_name);
        }
    }

    /**
     * Change the warehouse object
     *
     * @return void
     */
    public function change_warehouse()
    {
        $this->selected_warehouse = Warehouse::findOrFail($this->warehouse_id);
    }

    /**
     * Set local variables to current employee data
     * Fill the variable model
     *
     * @return void
     */
    public function edit()
    {
        $this->first_name = $this->employee->user->data->first_name;
        $this->last_name = $this->employee->user->data->last_name;
        $this->email = $this->employee->user->email;
        $this->phone_number = $this->employee->user->data->phone_number;
        $this->warehouse_id = $this->employee->warehouse_id;
        $this->user_role_id = $this->employee->user->user_role_id;
        $this->status = $this->employee->status;

        $this->change_warehouse();
    }

    /**
     * Update current changes $warehouse_id to database
     *
     * @return RedirectResponse
     */
    public function update()
    {
        $this->validate([
            'first_name' => ['required', 'min:2', 'max:25'],
            'last_name' => ['required', 'min:2', 'max:25'],
            'phone_number' => ['required', 'numeric', Rule::unique('user_data')->ignore($this->employee->user_id, 'user_id'), 'min_digits:8', 'max_digits:15'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->employee->user_id), 'min:10'],
            'warehouse_id' => ['required'],
            'user_role_id' => ['required'],
        ]);

        $this->change_warehouse();

        DB::transaction(function () {
            $user = User::findOrFail($this->employee->user_id);
            $user->email = $this->email;
            $user->user_role_id = $this->user_role_id;
            $user->save();

            $user_data = UserData::where('user_id', $this->employee->user_id)->first();
            $user_data->first_name = $this->first_name;
            $user_data->last_name = $this->last_name;
            $user_data->phone_number = $this->phone_number;
            $user_data->save();

            $this->employee->warehouse_id = $this->selected_warehouse->id;
            $this->employee->status = $this->status;
            $this->employee->save();
        });

        $this->redirect_page('employee.show', $this->employee->id);
    }
}
