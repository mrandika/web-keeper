@section('page')
    Hapus Warehouse
@endsection

@extends('layouts.sidebar.admin-nav')

@section('warehouse-active')
    active
@endsection

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('warehouse.show', $warehouse_id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Konfirmasi Penghapusan Warehouse</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('superadmin.home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('warehouse.index') }}">Warehouse</a></div>
                <div class="breadcrumb-item"><a href="{{ route('warehouse.show', $warehouse_id) }}">{{ $warehouse->name }}</a></div>
                <div class="breadcrumb-item">Hapus</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="empty-state" data-height="400">
                        @if ($count == 1)
                            <div class="empty-state-icon" style="background-color: orange">
                                <i class="fas fa-exclamation"></i>
                            </div>
                            <h2>Tidak dapat menghapus warehouse ini.</h2>
                            <p class="lead">
                                Warehouse ini tidak dapat dihapus karena merupakan warehouse terakhir anda.
                            </p>
                            <a href="{{ route('warehouse.show', $warehouse->id) }}" class="mt-4 bb">Kembali</a>
                        @else
                            <div class="empty-state-icon" style="background-color: red">
                                <i class="fas fa-exclamation"></i>
                            </div>
                            <h2>Anda yakin menghapus data warehouse ini?</h2>
                            <p class="lead">
                                Data yang berkaitan dengan warehouse ini, seperti pegawai, barang, dan transaksi akan dihapus. Aksi ini <b>TIDAK DAPAT</b> dikembalikan dan akan dicatat pada log sistem.
                            </p>
                            <a href="#" wire:click="destroy" class="btn btn-danger mt-4">Ya, hapus</a>

                            <a href="{{ route('warehouse.show', $warehouse->id) }}" class="mt-4 bb">Tidak, batalkan</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
