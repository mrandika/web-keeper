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

class DebitView extends Component
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

        return view('livewire.feature.transaction.debit-view', ['items' => $items])
            ->extends('layouts.dashboard')
            ->section('main');
    }

    /**
     * Get the item locations after the items is selected
     *
     * @return void
     */
    public function on_item_selected()
    {
        $this->locations = ItemLocation::where('item_id', $this->item_id)->get();
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
     * Add the current $this->item_id to the cart
     *
     * @return void
     */
    public function add_to_cart()
    {
        $item_idx = in_array($this->item_id, array_column($this->cart, 'id'));
        $this->item = Item::findOrFail($this->item_id);
        $total_stock = ItemLocation::where(['item_id' => $this->item_id, 'warehouse_storage_id' => $this->storage_id])->first()->stock;

        if ($this->qty < 1) {
            session()->flash('buy_error', 'Jumlah pembelian harus diatas atau sama dengan 1');
            return;
        }

        if ($item_idx === false) {
            $this->cart[] = ['id' => $this->item_id, 'item' => $this->item, 'storage_id' => $this->storage_id, 'max_qty' => $total_stock, 'qty' => $this->qty];
        } else {
            $this->qty('add', $this->item_id, $this->qty);
        }

        $this->calculate_total();
        $this->item_id = '0';
        $this->storage_id = '0';
        $this->qty = 0;
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

        if ($qty != null) {
            $this->cart[$item_idx]['qty'] += $qty;
        } else {
            if ($mode == 'add') {
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
                $transaction->transaction_type_id = TransactionType::where('code', 'DB')->first()->id;
                $transaction->employee_id = Employee::where('user_id', Auth::user()->id)->first()->id;
                $transaction->total = -$this->total;
                $transaction->save();

                foreach ($this->cart as $item) {
                    $detail = new TransactionDetail();
                    $item_location = ItemLocation::where(['item_id' => $item['id'], 'warehouse_storage_id' => $item['storage_id']])->first();
                    $item_location->stock += $item['qty'];

                    $detail->transaction_id = $transaction->id;
                    $detail->item_location_id = $item_location->id;
                    $detail->price = $item['item']['price'];
                    $detail->qty = $item['qty'];

                    $item_location->save();
                    $detail->save();
                }
            } catch (\Exception $exception) {
                session()->flash('buy_error', 'Pembelian barang gagal.');
                return;
            }
        });

        session()->flash('buy_success', 'Pembelian barang berhasil.');
        $this->cart = [];
        $this->total = 0;
    }
}
