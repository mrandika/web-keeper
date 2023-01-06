<?php

namespace App\Http\Livewire\Feature\Item;

use App\Models\Item;
use App\Models\ItemLocation;
use App\Models\Warehouse;
use App\Models\WarehouseStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class CreateView extends Component
{
    public $name, $sku, $price;

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        return view('livewire.feature.item.create-view')
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
     * Save the item data to database
     *
     * @return void
     */
    public function store()
    {
        $this->validate([
            'name' => ['required', 'min:5', 'max:75'],
            'sku' => ['required', 'min:2', 'max:25'],
            'price' => ['required', 'numeric']
        ]);

        $item = new Item();
        $item->name = $this->name;
        $item->sku = $this->sku;
        $item->price = $this->price;
        $item->save();

        return $this->redirect_page('item.location.create', $item->id);
    }
}
