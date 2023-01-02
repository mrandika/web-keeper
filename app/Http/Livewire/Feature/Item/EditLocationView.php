<?php

namespace App\Http\Livewire\Feature\Item;

use App\Models\Item;
use App\Models\ItemLocation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;

class EditLocationView extends Component
{
    public $location_id, $item_id;
    public $location, $item;
    public $stock;

    /**
     * Mount the Livewire component
     * Mounting the component will ONLY set the data once, even the view is refreshed/rerendered.
     *
     * @param $item_id
     * @return void
     */
    public function mount($location_id)
    {
        $this->location_id = $location_id;
    }

    public function render()
    {
        try {
            $this->location = ItemLocation::findOrFail($this->location_id);
            $this->item_id = $this->location->item_id;

            $this->item = Item::findOrFail($this->item_id);
        } catch (ModelNotFoundException $e) {
            $this->redirect_page('error');
        }

        return view('livewire.feature.item.edit-location-view')
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
     * Set local variables to current item data
     * Fill the variable model
     *
     * @return void
     */
    public function edit()
    {
        $this->stock = $this->location->stock;
    }

    /**
     * Update current changes $item_id to database
     *
     * @return void
     */
    public function update()
    {
        $this->location->stock = $this->stock;
        $this->location->save();

        $this->redirect_page('item.show', $this->item_id);
    }
}
