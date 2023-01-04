@section('page')
    Transaction
@endsection

@extends('layouts.sidebar')

@section('transaction-active')
    active
@endsection

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Transaksi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Transaksi</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active">Semua <span
                                            class="badge badge-white">{{ $transactions->count() }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link">Pembelian <span
                                            class="badge badge-primary">{{ $transactions->where('transaction_type_id', 1)->count() }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link">Penjualan <span
                                            class="badge badge-primary">{{ $transactions->where('transaction_type_id', 2)->count() }}</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Transaksi</h4>
                            <div class="card-header-action">
                                <a class="btn btn-warning btn-icon icon-left" href="{{ route('transaction.data') }}"><i
                                        class="fas fa-print"></i> Print</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Tipe Transaksi</th>
                                        <th>Admin</th>
                                        <th>Total Item</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                    @foreach($transactions->sortByDesc('created_at') as $transaction)
                                        <tr>
                                            <td>
                                                @if($transaction->transaction_type_id == 1)
                                                    <div class="badge badge-danger">Debit</div>
                                                @elseif($transaction->transaction_type_id == 2)
                                                    <div class="badge badge-primary">Credit</div>
                                                @endif
                                            </td>
                                            <td>
                                                <img alt="image" src="{{ asset('image/avatar-1.png') }}"
                                                     class="rounded-circle" width="35" data-toggle="title" title="">
                                                <div
                                                    class="d-inline-block ml-1">{{ $transaction->employee->user->data->fullname() }}</div>
                                            </td>
                                            <td>{{ $transaction->details->count() }} item</td>
                                            <td>@currency($transaction->total)</td>
                                            <td>{{ $transaction->created_at }}</td>
                                            <td>
                                                <a class="btn btn-primary"
                                                   href="{{ route('transaction.show', $transaction->id) }}">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $transactions->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
