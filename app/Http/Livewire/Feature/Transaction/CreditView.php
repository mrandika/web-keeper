<?php

namespace App\Http\Livewire\Feature\Transaction;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\Item;
use App\Models\ItemLocation;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class CreditView extends Component
{
    public $item_id = '0', $storage_id = '0', $qty = 0;
    public $locations;
    public $item;
    public $cart = [], $total = 0;

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
        })->get();

        return view('livewire.feature.transaction.credit-view', ['items' => $items])
            ->extends('layouts.dashboard')
            ->section('main');
    }

    /**
     * Set the current cart total price
     *
     * @return void
     */
    public function calculate_total()
    {
        $this->total = 0;

        foreach ($this->cart as $item) {
            $this->total += $item['item']['price'] * $item['qty'];
        }
    }

    /**
     * Set the default quantity (1) after the storage is selected
     *
     * @return void
     */
    public function on_storage_selected()
    {
        $this->qty = 1;
    }

    /**
     * Add the $item_id to cart
     *
     * @param string $item_id   The item's ID
     * @return void
     */
    public function add_to_cart($item_id)
    {
        if ($this->storage_id == null || $this->storage_id == '0') {
            session()->flash('sell_error', 'Lokasi penyimpanan tidak boleh kosong!');
            return;
        }

        $item_idx = in_array($item_id, array_column($this->cart, 'id'));
        $this->item = Item::findOrFail($item_id);
        $total_stock = ItemLocation::where(['item_id' => $item_id, 'warehouse_storage_id' => $this->storage_id])->first()->stock;

        if ($item_idx === false) {
            $this->cart[] = ['id' => $item_id, 'item' => $this->item, 'storage_id' => $this->storage_id, 'max_qty' => $total_stock, 'qty' => $this->qty];
        } else {
            $this->qty('add', $item_id, $this->qty);
        }

        $this->calculate_total();
    }

    /**
     * Add or remove the items from the cart
     *
     * @param string $mode      The qty mode, either 'add'|'sub'
     * @param string $item_id   The item's ID
     * @param int $qty          Amount of added/substracted quantity
     * @return void
     */
    public function qty($mode, $item_id, $qty = null)
    {
        $item_idx = array_search($item_id, array_column($this->cart, 'id'));
        $item = $this->cart[$item_idx];

        $min_qty = 1;
        $max_qty = $item['max_qty'];

        if ($qty != null) {
            if ($item['qty'] + $qty <= $max_qty) {
                $this->cart[$item_idx]['qty'] += $qty;
            } else {
                session()->flash('sell_error', 'Jumlah penjualan pada cart melebihi stok produk yang tersedia.');
                return;
            }
        } else {
            if ($mode == 'add' && $item['qty'] < $max_qty) {
                $this->cart[$item_idx]['qty'] += 1;
            } else if ($mode == 'sub' && $item['qty'] > $min_qty) {
                $this->cart[$item_idx]['qty'] -= 1;
            }
        }

        $this->calculate_total();
    }

    /**
     * Checkout the cart
     *
     * @return void
     */
    public function checkout()
    {
        DB::transaction(function () {
            try {
                $transaction = new Transaction();
                $transaction->transaction_type_id = TransactionType::where('code', 'CR')->first()->id;
                $transaction->employee_id = Employee::where('user_id', Auth::user()->id)->first()->id;
                $transaction->total = $this->total;
                $transaction->save();

                foreach ($this->cart as $item) {
                    $detail = new TransactionDetail();
                    $item_location = ItemLocation::where(['item_id' => $item['id'], 'warehouse_storage_id' => $item['storage_id']])->first();
                    $item_location->stock -= $item['qty'];

                    $detail->transaction_id = $transaction->id;
                    $detail->item_location_id = $item_location->id;
                    $detail->price = $item['item']['price'];
                    $detail->qty = $item['qty'];

                    $item_location->save();
                    $detail->save();
                }
            } catch (\Exception $exception) {
                session()->flash('sell_error', 'Penjualan barang gagal.');
                return;
            }
        });

        session()->flash('sell_success', 'Penjualan barang berhasil.');
        $this->cart = [];
        $this->total = 0;
    }
}
