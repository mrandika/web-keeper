@section('page')
    Transaction Detail
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
            <h1>Invoice</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('superadmin.home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('transaction.index') }}">Invoice</a></div>
                <div class="breadcrumb-item">{{ $transaction->created_at }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="invoice" id="print_area">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Invoice</h2>
                                <div class="invoice-number">Order {{ $transaction->created_at }}</div>
                            </div>
                            <hr>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <address>
                                <strong>Admin</strong><br>
                                {{ $transaction->employee->user->data->fullname() }}
                            </address>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title">Ringkasan Transaksi</div>
                            <p class="section-lead">Semua item tidak dapat ditukar atau dikembalikan.</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th>Nama Item</th>
                                        <th class="text-center">Harga Satuan</th>
                                        <th class="text-center">Kuantitas</th>
                                        <th class="text-right">Total</th>
                                    </tr>

                                    @foreach($transaction->details as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->location->item->name }}</td>
                                            <td class="text-center">Rp. {{ $item->price }}</td>
                                            <td class="text-center">{{ $item->qty }}</td>
                                            <td class="text-right">Rp. {{ $item->price * $item->qty }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-12 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">Rp. {{ $transaction->total }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    <button class="btn btn-warning btn-icon icon-left" onclick="print('#print_area')"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </section>
</div>
