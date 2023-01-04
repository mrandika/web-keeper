<?php

namespace App\Http\Livewire\Feature\Employee;

use App\Models\Employee;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class CreateView extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search_user = '', $search_warehouse = '';
    public $selected_user = null, $selected_warehouse = null;

    public $role_id;

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        $user = Auth::user();

        $users = User::doesntHave('employees')->with('data')->whereHas('data', function ($data_query) {
            $data_query->where('first_name', 'like', '%'.$this->search_user.'%')
                ->orWhere('last_name', 'like', '%'.$this->search_user.'%');
        })->paginate(5);

        if ($user->role->name == 'Super-Admin') {
            $warehouses = Warehouse::where('user_id', $user->id)->where('name', 'like', '%'.$this->search_warehouse.'%')->get();
        } else {
            $warehouses = Warehouse::whereIn('id', $user->employees->pluck('warehouse_id')->toArray())->where('name', 'like', '%'.$this->search_warehouse.'%')->get();
        }

        return view('livewire.feature.employee.create-view', ['users' => $users, 'warehouses' => $warehouses])
            ->extends('layouts.dashboard')
            ->section('main');
    }

    /**
     * Select the user object
     *
     * @param $user_id
     * @return void
     */
    public function select_user($user_id)
    {
        $this->selected_user = User::findOrFail($user_id);
    }

    /**
     * Select the warehouse object
     *
     * @param $warehouse_id
     * @return void
     */
    public function select_warehouse($warehouse_id)
    {
        $this->selected_warehouse = Warehouse::findOrFail($warehouse_id);
    }

    /**
     * Save the employee data to database
     *
     * @return void
     */
    public function store()
    {
        DB::transaction(function () {
            $user = $this->selected_user;
            $user->user_role_id = $this->role_id;
            $user->save();

            $employee = new Employee();
            $employee->user_id = $user->id;
            $employee->warehouse_id = $this->selected_warehouse->id;
            $employee->status = 1;
            $employee->save();
        });

        session()->flash('success', 'Employee Saved.');

        $this->selected_user = null;
        $this->selected_warehouse = null;
        $this->role_id = '';
    }
}
