<?php

namespace App\Http\Livewire\Feature\Item;

use App\Models\Item;
use App\Models\ItemLocation;
use App\Models\Warehouse;
use App\Models\WarehouseStorage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class CreateLocationView extends Component
{
    public $warehouses, $storages = [];
    public $warehouse_id = '0', $storage_id = '0';
    public $stock;
    public $item_id;
    public $item;

    /**
     * Mount the Livewire component
     * Mounting the component will ONLY set the data once, even the view is refreshed/rerendered.
     *
     * @param $item_id
     * @return void
     */
    public function mount($item_id)
    {
        $this->item_id = $item_id;
    }

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        $user = Auth::user();
        $this->warehouses = Warehouse::where('user_id', $user->id)->get();

        try {
            $this->item = Item::findOrFail($this->item_id);
        } catch (ModelNotFoundException $e) {
            $this->redirect_page('error');
        }

        return view('livewire.feature.item.create-location-view', ['warehouses' => $this->warehouses, 'item' => $this->item])
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
     * Get storages for specified $warehouse_id
     *
     * @return void
     */
    public function get_storages()
    {
        $this->storages = WarehouseStorage::with('aisle')->whereHas('aisle', function ($aisle_query) {
            $aisle_query->with('warehouse')->whereHas('warehouse', function ($wh_query) {
                $wh_query->where('id', $this->warehouse_id);
            });
        })->get();
    }

    /**
     * Save the location data to database
     *
     * @return void
     */
    public function store()
    {
        $this->validate([
            'warehouse_id' => ['required'],
            'storage_id' => ['required'],
            'stock' => ['required', 'numeric']
        ]);

        $location = new ItemLocation();
        $location->item_id = $this->item_id;
        $location->warehouse_storage_id = $this->storage_id;
        $location->stock = $this->stock;
        $location->save();

        return $this->redirect_page('item.show', $this->item->id);
    }
}
