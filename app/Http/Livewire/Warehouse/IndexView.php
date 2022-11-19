<?php

namespace App\Http\Livewire\Warehouse;

use App\Models\Employee;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class IndexView extends Component
{
    public $search_value = '';

    /**
     * Reset the page when search value is updated
     *
     * @return void
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        $user = Auth::user();

        $warehouses = Warehouse::where('user_id', $user->id)->where('name', 'like', '%'.$this->search_value.'%')->get();

        return view('livewire.warehouse.index-view', ['warehouses' => $warehouses])
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
}
