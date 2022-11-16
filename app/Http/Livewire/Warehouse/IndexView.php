<?php

namespace App\Http\Livewire\Warehouse;

use App\Models\Employee;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class IndexView extends Component
{
    public $search_value = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function redirect_page(string $route_name, $param = null)
    {
        if (isset($param)) {
            return redirect()->route($route_name, $param);
        } else {
            return redirect()->route($route_name);
        }
    }

    public function render()
    {
        $user = Auth::user();

        $warehouses = Warehouse::where('user_id', $user->id)->where('name', 'like', '%'.$this->search_value.'%')->get();

        return view('livewire.warehouse.index-view', ['warehouses' => $warehouses])
            ->extends('layouts.dashboard')
            ->section('main');
    }
}
