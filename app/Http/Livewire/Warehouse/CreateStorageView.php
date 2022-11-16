<?php

namespace App\Http\Livewire\Warehouse;

use App\Models\WarehouseAisle;
use App\Models\WarehouseAisleColumn;
use App\Models\WarehouseAisleRow;
use App\Models\WarehouseStorage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateStorageView extends Component
{
    public $warehouse_id;
    public $code, $aisle, $column, $row;

    public function mount($warehouse_id)
    {
        $this->warehouse_id = $warehouse_id;
    }

    public function render()
    {
        return view('livewire.warehouse.create-storage-view')
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

    public function save_storage()
    {
        $this->validate([
            'code' => ['required', 'min:2', 'max:6'],
            'aisle' => ['required', 'numeric'],
            'column' => ['required', 'numeric'],
            'row' => ['required', 'numeric'],
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
