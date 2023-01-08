<?php

namespace App\Http\Livewire\Feature\Warehouse;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;

class EditView extends Component
{
    public $warehouse;
    public $name, $address, $longitude, $latitude;
    public $warehouse_id;

    /**
     * Mount the Livewire component
     * Mounting the component will ONLY set the data once, even the view is refreshed/rerendered.
     *
     * @return void
     */
    public function mount($warehouse_id)
    {
        $this->warehouse_id = $warehouse_id;
    }

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        try {
            $this->warehouse = Warehouse::findOrFail($this->warehouse_id);
        } catch (ModelNotFoundException $e) {
            $this->redirect_page('error');
        }

        return view('livewire.feature.warehouse.edit-view', ['warehouse' => $this->warehouse])
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
     * Set local variables to current warehouse data
     * Fill the variable model
     *
     * @return void
     */
    public function edit()
    {
        $this->name = $this->warehouse->name;
        $this->address = $this->warehouse->address;
        $this->latitude = $this->warehouse->latitude;
        $this->longitude = $this->warehouse->longitude;
    }

    /**
     * Update current changes $warehouse_id to database
     *
     * @return RedirectResponse
     */
    public function update()
    {
        $this->validate([
            'name' => ['required', 'min:10', 'max:75'],
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
