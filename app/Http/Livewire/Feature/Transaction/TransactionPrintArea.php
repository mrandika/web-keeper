<?php

namespace App\Http\Livewire\Feature\Transaction;

use Illuminate\View\View;
use Livewire\Component;

class TransactionPrintArea extends Component
{
    public $transaction;

    /**
     * Mount the Livewire component
     * Mounting the component will ONLY set the data once, even the view is refreshed/rerendered.
     *
     * @return void
     */
    public function mount($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        return view('livewire.feature.transaction.transaction-print-area')
            ->extends('layouts.app')
            ->section('content');
    }
}
