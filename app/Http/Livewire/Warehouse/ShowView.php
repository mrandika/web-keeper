<?php

namespace App\Http\Livewire\Warehouse;

use App\Models\ItemLocation;
use App\Models\Warehouse;
use Livewire\Component;

class ShowView extends Component
{
    public $warehouse;
    public $name, $address;
    public $warehouse_id;

    public function mount($warehouse_id)
    {
        $this->warehouse_id = $warehouse_id;
    }

    public function render()
    {
        $this->warehouse = Warehouse::find($this->warehouse_id);

        return view('livewire.warehouse.show-view', ['warehouse' => $this->warehouse])
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
}
