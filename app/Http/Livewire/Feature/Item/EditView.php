<?php

namespace App\Http\Livewire\Feature\Item;

use App\Models\Item;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;

class EditView extends Component
{
    public $name, $sku, $price;
    public $warehouse_id = '0', $storage_id = '0';
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
        try {
            $this->item = Item::findOrFail($this->item_id);
        } catch (ModelNotFoundException $e) {
            $this->redirect_page('error');
        }

        return view('livewire.feature.item.edit-view')
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
        $this->name = $this->item->name;
        $this->sku = $this->item->sku;
        $this->price = $this->item->price;
    }

    /**
     * Update current changes $item_id to database
     *
     * @return RedirectResponse
     */
    public function update()
    {
        $this->validate([
            'name' => ['required', 'min:5', 'max:75'],
            'sku' => ['required', 'min:2', 'max:25'],
            'price' => ['required', 'numeric']
        ]);

        $this->item->name = $this->name;
        $this->item->sku = $this->sku;
        $this->item->price = $this->price;
        $this->item->save();

        return $this->redirect_page('item.show', $this->item->id);
    }
}
