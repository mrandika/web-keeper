<?php

namespace App\Http\Livewire\Feature\Item;

use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;

class DestroyView extends Component
{
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
        $this->item = Item::findOrFail($this->item_id);

        return view('livewire.feature.item.destroy-view', ['item' => $this->item])
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
     * @param string $key       Session key
     * @param string $value     Session value
     * @return void
     */
    public function flash_message(string $key, string $value)
    {
        session()->flash($key, $value);
    }

    public function destroy()
    {
        $this->item->delete();

        $this->flash_message('info', "Barang dengan nama ".$this->item->name." berhasil dihapus.");
        $this->redirect_page('item.index');
    }
}
