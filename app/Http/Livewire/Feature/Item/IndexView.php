<?php

namespace App\Http\Livewire\Feature\Item;

use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class IndexView extends Component
{
    public $search_value = '';

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        $user = Auth::user();

        $items = Item::with('locations')->whereHas('locations', function ($location_query) use ($user) {
            $location_query->with('storage')->whereHas('storage', function ($storage_query) use ($user) {
                $storage_query->with('aisle')->whereHas('aisle', function ($aisle_query) use ($user) {
                    $aisle_query->with('warehouse')->whereHas('warehouse', function ($wh_query) use ($user) {
                        $wh_query->where('user_id', $user->id);
                    });
                });
            });
        })->where('name', 'like', '%'.$this->search_value.'%')->paginate(10);

        return view('livewire.feature.item.index-view', ['items' => $items])
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
