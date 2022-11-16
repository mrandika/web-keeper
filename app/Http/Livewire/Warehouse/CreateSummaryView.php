<?php

namespace App\Http\Livewire\Warehouse;

use App\Models\Warehouse;
use Livewire\Component;

class CreateSummaryView extends Component
{
    public $warehouse_id;
    public $long, $lat;

    public function mount($warehouse_id)
    {
        $this->warehouse_id = $warehouse_id;
    }

    public function render()
    {
        $warehouse = Warehouse::find($this->warehouse_id);
        $this->long = $warehouse->longitude;
        $this->lat = $warehouse->latitude;

        return view('livewire.warehouse.create-summary-view', ['warehouse' => $warehouse])
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
