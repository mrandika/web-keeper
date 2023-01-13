<?php

namespace App\Http\Livewire\Feature\Transaction;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class TransactionSelectionView extends Component
{
    protected $listeners = [
      'refreshComponent' => '$refresh'
    ];

    public $date = '01-01-2020 - 31-12-2022';
    public $type = ['DB', 'CR'];
    public $transactions;

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        return view('livewire.feature.transaction.transaction-selection-view')
            ->extends('layouts.dashboard')
            ->section('main');
    }

    /**
     * Search the transaction with date and transaction type
     *
     * @return void
     */
    public function search_transaction()
    {
        $user = Auth::user();

        $date = explode(' - ', $this->date);
        $from = date('Y-m-d H:i:s', strtotime($date[0].' 00:00:00'));
        $to = date('Y-m-d H:i:s', strtotime($date[1].' 23:59:59'));
        $type = [];

        if (in_array('DB', $this->type)) {
            $type[] = 1;
        }

        if (in_array('CR', $this->type)) {
            $type[] = 2;
        }

        $this->transactions = Transaction::with('details.location.storage.aisle.warehouse')->whereHas('details.location.storage.aisle.warehouse', function ($query) use ($user) {
            if ($user->role->name == 'Super-Admin') {
                $query->where('user_id', $user->id);
            } else {
                $query->whereIn('id', $user->employees->pluck('warehouse_id')->toArray());
            }
        })->whereBetween('created_at', [$from, $to])->whereIn('transaction_type_id', $type)->get();

        $this->emit('refreshComponent');
    }

    /**
     * Print the data as PDF
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function print_data()
    {
        $pdf = Pdf::loadView('livewire/feature/transaction/transaction-print-area', ['transactions' => $this->transactions])->output();

        return response()->streamDownload(
            fn () => print($pdf), "Laporan Transaksi Keeper ($this->date).pdf"
        );
    }
}
