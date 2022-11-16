<?php

namespace App\Http\Livewire\Warehouse;

use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DestroyView extends Component
{
    public $warehouse;
    public $warehouse_id;

    public function mount($warehouse_id)
    {
        $this->warehouse_id = $warehouse_id;
    }

    public function render()
    {
        $warehouse_counts = Warehouse::where('user_id', Auth::user()->id)->count();
        $this->warehouse = Warehouse::findOrFail($this->warehouse_id);

        return view('livewire.warehouse.destroy-view', ['warehouse' => $this->warehouse, 'count' => $warehouse_counts])
            ->extends('layouts.dashboard')
            ->section('main');
    }

    public function redirect_page(string $route_name, $param = null)
    {
        if (isset($param)) {
            return redirect()->route($route_name, $param);
        } else {
            return redirect()->route($route_name);
        }
    }

    public function flash_message(string $key, string $value)
    {
        session()->flash($key, $value);
    }

    public function destroy()
    {
        $warehouse = Warehouse::find($this->warehouse_id);
        $warehouse->delete();

        $this->flash_message('info', "Warehouse dengan nama `$warehouse->name` berhasil dihapus.");
        $this->redirect_page('warehouse.index');
    }
}
