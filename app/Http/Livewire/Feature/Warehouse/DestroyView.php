<?php

namespace App\Http\Livewire\Feature\Warehouse;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class DestroyView extends Component
{
    public $warehouse;
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
        $warehouse_counts = Warehouse::where('user_id', Auth::user()->id)->count();

        try {
            $this->warehouse = Warehouse::findOrFail($this->warehouse_id);
        } catch (ModelNotFoundException $e) {
            $this->redirect_page('error');
        }

        return view('livewire.feature.warehouse.destroy-view', ['warehouse' => $this->warehouse, 'count' => $warehouse_counts])
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
     * Set flash message for this current session
     *
     * @return void
     */
    public function flash_message(string $key, string $value)
    {
        session()->flash($key, $value);
    }

    /**
     * Destroy the $warehouse_id from database
     *
     * @return RedirectResponse
     */
    public function destroy()
    {
        $warehouse = Warehouse::find($this->warehouse_id);
        $warehouse->delete();

        $this->flash_message('info', "Warehouse dengan nama `$warehouse->name` berhasil dihapus.");
        $this->redirect_page('warehouse.index');
    }
}
