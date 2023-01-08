<?php

namespace App\Http\Livewire\Feature\Transaction;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class TransactionView extends Component
{
    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        $user = Auth::user();

        $transactions = Transaction::with('details.location.storage.aisle.warehouse')->whereHas('details.location.storage.aisle.warehouse', function ($query) use ($user) {
            if ($user->role->name == 'Super-Admin') {
                $query->where('user_id', $user->id);
            } else {
                $query->whereIn('id', $user->employees->pluck('warehouse_id')->toArray());
            }
        })->paginate(15);

        return view('livewire.feature.transaction.transaction-view', ['transactions' => $transactions])
            ->extends('layouts.dashboard')
            ->section('main');
    }
}
