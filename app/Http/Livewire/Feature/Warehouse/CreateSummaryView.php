<?php

namespace App\Http\Livewire\Feature\Warehouse;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;

class CreateSummaryView extends Component
{
    public $warehouse_id, $warehouse;
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
        try {
            $this->warehouse = Warehouse::findOrFail($this->warehouse_id);
        } catch (ModelNotFoundException $e) {
            $this->redirect_page('error');
        }

        $this->long = $this->warehouse->longitude;
        $this->lat = $this->warehouse->latitude;

        return view('livewire.feature.warehouse.create-summary-view', ['warehouse' => $this->warehouse])
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
