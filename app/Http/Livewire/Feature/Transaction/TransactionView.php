<?php

namespace App\Http\Livewire\Feature\Transaction;

use App\Models\Transaction;
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
        $transactions = Transaction::paginate(15);

        return view('livewire.feature.transaction.transaction-view', ['transactions' => $transactions])
            ->extends('layouts.dashboard')
            ->section('main');
    }
}
