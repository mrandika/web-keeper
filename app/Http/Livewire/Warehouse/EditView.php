<?php

namespace App\Http\Livewire\Warehouse;

use App\Models\Warehouse;
use Livewire\Component;

class EditView extends Component
{
    public $warehouse;
    public $name, $address, $longitude, $latitude;
    public $warehouse_id;

    public function mount($warehouse_id)
    {
        $this->warehouse_id = $warehouse_id;
    }

    public function render()
    {
        $this->warehouse = Warehouse::find($this->warehouse_id);
        return view('livewire.warehouse.edit-view', ['warehouse' => $this->warehouse])
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

    public function edit()
    {
        $this->name = $this->warehouse->name;
        $this->address = $this->warehouse->address;
        $this->latitude = $this->warehouse->latitude;
        $this->longitude = $this->warehouse->longitude;
    }

    public function update()
    {
        $this->validate([
            'name' => ['required', 'min:10'],
            'address' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
        ]);

        $warehouse = Warehouse::find($this->warehouse_id);
        $warehouse->name = $this->name;
        $warehouse->address = $this->address;
        $warehouse->latitude = $this->latitude;
        $warehouse->longitude = $this->longitude;
        $warehouse->save();

        $this->redirect_page('warehouse.show', $this->warehouse_id);
    }
}
