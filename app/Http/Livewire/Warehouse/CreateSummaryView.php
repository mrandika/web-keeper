<?php

namespace App\Http\Livewire\Warehouse;

use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;

class CreateSummaryView extends Component
{
    public $warehouse_id;
    public $long, $lat;

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
        $warehouse = Warehouse::findOrFail($this->warehouse_id);
        $this->long = $warehouse->longitude;
        $this->lat = $warehouse->latitude;

        return view('livewire.warehouse.create-summary-view', ['warehouse' => $warehouse])
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
