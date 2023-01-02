<?php

namespace App\Http\Livewire\SuperAdmin;

use App\Models\Item;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class DashboardView extends Component
{
    public $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Des'];
    public $credit_data = [], $debit_data = [];

    public function mount()
    {
        $this->credit_data = array_fill(0, 12, 0);
        $this->debit_data = array_fill(0, 12, 0);
    }

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        $user = Auth::user();
        $transactions = Transaction::whereMonth('created_at', Carbon::today())->whereYear('created_at', Carbon::today())->get();
        $warehouses = Warehouse::where('user_id', $user->id)->get();
        $items = Item::with(['locations', 'locations.storage', 'locations.storage.aisle', 'locations.storage.aisle.warehouse'])
            ->whereHas('locations.storage.aisle.warehouse', function ($query) use ($warehouses) {
                $query->whereIn('warehouse_id', $warehouses->pluck('id')->toArray());
            })
            ->get();

        $total_storage = 0;

        $total_asset = Item::with(['locations' => function ($query) {
            $query->select('id', 'item_id', 'stock');
        }])->get()->sum(function ($item) {
            return $item->locations->sum(function ($location) use ($item) {
                return $location->stock * $item->price;
            });
        });

        $credit_data = Transaction::select(
            DB::raw('sum(total) as sums'),
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
        )->whereYear('created_at', Carbon::today())->where('transaction_type_id', 2)->groupBy('months')->get()->pluck('sums')->toArray();

        $debit_data = Transaction::select(
            DB::raw('sum(total) as sums'),
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
        )->whereYear('created_at', Carbon::today())->where('transaction_type_id', 1)->groupBy('months')->get()->pluck('sums')->toArray();

        for ($i = 0; $i < count($credit_data); $i++) {
            $this->credit_data[$i] = $credit_data[$i];
        }

        for ($i = 0; $i < count($debit_data); $i++) {
            $this->debit_data[$i] = abs($debit_data[$i]);
        }

        $top_items = TransactionDetail::with(['location.item'])
            ->join('item_locations', 'item_locations.id', '=', 'transaction_details.item_location_id')
            ->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->select('item_locations.item_id', DB::raw('sum(transaction_details.qty) as total_sold'))
            ->where('transactions.transaction_type_id', 2)
            ->groupBy('item_locations.item_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('livewire.super-admin.dashboard-view', [
            'transactions' => $transactions,
            'warehouses' => $warehouses,
            'items' => $items,
            'total_asset' => $total_asset,
            'total_storage' => $total_storage,
            'items' => $items,
            'top_items' => $top_items
        ])
            ->extends('layouts.dashboard')
            ->section('main');
    }
}
