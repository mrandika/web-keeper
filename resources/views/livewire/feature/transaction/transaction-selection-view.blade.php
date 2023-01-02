@section('page')
    Transaction
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
@endsection

@extends('layouts.sidebar.admin-nav')

@section('transaction-active')
    active
@endsection

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('transaction.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Pilih Transaksi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('transaction.index') }}">Transaksi</a></div>
                <div class="breadcrumb-item">Data Transaksi</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Filter Data Transaksi</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label>Tanggal Transaksi</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control daterange-cus" wire:model="date">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tipe Transaksi</label>
                                <div class="selectgroup selectgroup-pills">
                                    <label class="selectgroup-item">
                                        <input type="checkbox" name="value" value="DB" wire:model="type" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">Debit</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="checkbox" name="value" value="CR" wire:model="type" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">Credit</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button wire:click="search_transaction" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Transaksi</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tipe Transaksi</th>
                                    <th scope="col">Admin</th>
                                    <th scope="col">Total Barang</th>
                                    <th scope="col">Total Harga</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                $total = 0;
                                @endphp
                                @forelse($transactions ?? [] as $transaction)
                                    @php
                                        $total += $transaction->total;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            @if($transaction->transaction_type_id == 1)
                                                <div class="badge badge-danger">Debit</div>
                                            @elseif($transaction->transaction_type_id == 2)
                                                <div class="badge badge-primary">Credit</div>
                                            @endif
                                        </td>
                                        <td>{{ $transaction->employee->user->data->fullname() }} ({{ $transaction->employee->user->email }})</td>
                                        <td>{{ $transaction->details->count() }} barang</td>
                                        <td>Rp. {{ $transaction->total }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <th colspan="5">Tidak ada data</th>
                                    </tr>
                                @endforelse

                                @if ($transactions != null)
                                    <tr>
                                        <td colspan="4"></td>
                                        <th>Rp. {{ $total }}</th>
                                    </tr>
                                @endif
                                </tbody>
                            </table>

                        </div>
                        <div class="card-footer text-right">
                            @if ($transactions != null)
                                <a class="btn btn-warning btn-icon icon-left" wire:click="print_data"><i class="fas fa-print"></i> Print</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@section('js')
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script>
        $('.daterange-cus').daterangepicker({
            locale: {format: 'DD-MM-YYYY'},
            drops: 'down',
            opens: 'down'
        });
        $('.daterange-cus').on('change', function (e) {
            @this.set('date', e.target.value);
        });
    </script>
@endsection
