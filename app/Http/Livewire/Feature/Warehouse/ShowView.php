<?php

namespace App\Http\Livewire\Feature\Warehouse;

use App\Models\Item;
use App\Models\ItemLocation;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class ShowView extends Component
{
    public $warehouse;
    public $name, $address;
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
        $user = Auth::user();

        try {
            $this->warehouse = Warehouse::findOrFail($this->warehouse_id);
        } catch (ModelNotFoundException $e) {
            $this->redirect_page('error');
        }

        $items = Item::with('locations')->whereHas('locations', function ($location_query) use ($user) {
            $location_query->with('storage')->whereHas('storage', function ($storage_query) use ($user) {
                $storage_query->with('aisle')->whereHas('aisle', function ($aisle_query) use ($user) {
                    $aisle_query->with('warehouse')->whereHas('warehouse', function ($wh_query) use ($user) {
                        $wh_query->where('id', $this->warehouse_id)->where('user_id', $user->id);
                    });
                });
            });
        })->get();

        return view('livewire.feature.warehouse.show-view', ['warehouse' => $this->warehouse, 'items' => $items])
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
