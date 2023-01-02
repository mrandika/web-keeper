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
        $items = Item::with('locations')->whereHas('locations', function ($location_query) use ($user, $warehouses) {
            $location_query->with('storage')->whereHas('storage', function ($storage_query) use ($warehouses) {
                $storage_query->with('aisle')->whereHas('aisle', function ($aisle_query) use ($warehouses) {
                    $aisle_query->with('warehouse')->whereHas('warehouse', function ($wh_query) use ($warehouses) {
                       $wh_query->whereIn('warehouse_id', $warehouses->pluck('id')->toArray());
                    });
                });
            });
        })->get();

        $total_asset = 0;
        $total_storage = 0;

        foreach ($items as $item) {
            foreach ($item->locations as $location) {
                $total_asset += $item->price * $location->stock;
                $total_storage += 1;
            }
        }

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

        $items = TransactionDetail::join('item_locations', 'item_locations.id', '=', 'transaction_details.item_location_id')
            ->select('item_id', DB::raw('sum(qty) as total_sold'))
            ->groupBy('item_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('livewire.super-admin.dashboard-view', [
            'transactions' => $transactions,
            'warehouses' => $warehouses,
            'items' => $items,
            'total_asset' => $total_asset,
            'total_storage' => $total_storage,
            'items' => $items
        ])
            ->extends('layouts.dashboard')
            ->section('main');
    }
}
