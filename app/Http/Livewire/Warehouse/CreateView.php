<?php

namespace App\Http\Livewire\Warehouse;

use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class CreateView extends Component
{
    public $warehouse;

    protected $rules = [
        'warehouse.name' => ['required', 'min:10', 'max:75'],
        'warehouse.address' => ['required'],
        'warehouse.latitude' => ['required'],
        'warehouse.longitude' => ['required'],
    ];

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        return view('livewire.warehouse.create-view')
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
     * Save the warehouse data to database
     *
     * @return RedirectResponse
     */
    public function save_basic()
    {
        $this->validate();

        $this->warehouse['user_id'] = Auth::user()->id;
        $warehouse = Warehouse::create($this->warehouse);

        $this->redirect_page('warehouse.create.storage', $warehouse->id);
    }
}
