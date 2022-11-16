<?php

namespace App\Http\Livewire\Warehouse;

use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateView extends Component
{
    public $warehouse;

    protected $rules = [
        'warehouse.name' => ['required', 'min:10'],
        'warehouse.address' => ['required'],
        'warehouse.latitude' => ['required'],
        'warehouse.longitude' => ['required'],
    ];

    public function render()
    {
        return view('livewire.warehouse.create-view')
            ->extends('layouts.dashboard')
            ->section('main');
    }

    public function redirect_page(string $route_name, $param = null)
    {
        if (isset($param)) {
            return redirect()->route($route_name, $param);
        } else {
            return redirect()->route($route_name);
        }
    }

    public function save_basic()
    {
        $this->validate();

        $this->warehouse['user_id'] = Auth::user()->id;
        $warehouse = Warehouse::create($this->warehouse);

        $this->redirect_page('warehouse.create.storage', $warehouse->id);
    }
}
