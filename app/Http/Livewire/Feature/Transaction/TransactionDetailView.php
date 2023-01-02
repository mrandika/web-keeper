<?php

namespace App\Http\Livewire\Feature\Transaction;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\View\View;
use Livewire\Component;

class TransactionDetailView extends Component
{
    public $transaction_id, $transaction;

    /**
     * Mount the Livewire component
     * Mounting the component will ONLY set the data once, even the view is refreshed/rerendered.
     *
     * @return void
     */
    public function mount($transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        try {
            $this->transaction = Transaction::findOrFail($this->transaction_id);
        } catch (ModelNotFoundException $e) {
            $this->redirect_page('error');
        }

        return view('livewire.feature.transaction.transaction-detail-view', ['transaction' => $this->transaction])
            ->extends('layouts.dashboard')
            ->section('main');
    }
}
