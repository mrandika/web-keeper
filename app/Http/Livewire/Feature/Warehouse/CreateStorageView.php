<?php

namespace App\Http\Livewire\Feature\Warehouse;

use App\Models\WarehouseAisle;
use App\Models\WarehouseAisleColumn;
use App\Models\WarehouseAisleRow;
use App\Models\WarehouseStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class CreateStorageView extends Component
{
    public $warehouse_id;
    public $code, $aisle, $column, $row;

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
        return view('livewire.feature.warehouse.create-storage-view')
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
     * Save the storage for given $warehouse_id
     *
     * @return RedirectResponse
     */
    public function save_storage()
    {
        $this->validate([
            'code' => ['required', 'min:2', 'max:6'],
            'aisle' => ['required', 'numeric', 'between:1,5'],
            'column' => ['required', 'numeric', 'between:1,5'],
            'row' => ['required', 'numeric', 'between:1,5'],
        ]);

        DB::transaction(function () {
            for ($i = 1; $i <= $this->aisle; $i++) {
                $aisle_code = $this->code.'-A'.$i;
                $aisle = new WarehouseAisle();
                $aisle->warehouse_id = $this->warehouse_id;
                $aisle->code = $aisle_code;
                $aisle->save();

                for ($j = 1; $j <= $this->column; $j++) {
                    $column_code = $aisle_code.'-C'.$j;
                    $column = new WarehouseAisleColumn();
                    $column->warehouse_aisle_id = $aisle->id;
                    $column->code = $column_code;
                    $column->save();

                    for ($k = 1; $k <= $this->row; $k++) {
                        $row_code = $column_code.'-R'.$k;
                        $row = new WarehouseAisleRow();
                        $row->warehouse_aisle_column_id = $column->id;
                        $row->code = $row_code;
                        $row->save();

                        $storage = new WarehouseStorage();
                        $storage->warehouse_aisle_id = $aisle->id;
                        $storage->warehouse_aisle_column_id = $column->id;
                        $storage->warehouse_aisle_row_id = $row->id;
                        $storage->save();
                    }
                }
            }
        });

        $this->redirect_page('warehouse.create.summary', $this->warehouse_id);
    }
}
