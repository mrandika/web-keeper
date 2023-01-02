@section('page')
    Create Item
@endsection

@extends('layouts.sidebar.admin-nav')

@section('item-active')
    active
@endsection

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('item.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Buat Barang</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('item.index') }}">Item</a></div>
                <div class="breadcrumb-item">Tambah Baru</div>
            </div>
        </div>

        <div class="section-body">
            <div class="section-body">
                <form wire:submit.prevent="store">
                    <div class="card">
                        <div class="card-header">
                            <h4>Item Data</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Nama Barang</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Barang" wire:model="name">

                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">SKU</label>
                                    <input type="text" class="form-control @error('sku') is-invalid @enderror" placeholder="Stock Keeping Unit" wire:model="sku">

                                    @error('sku')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword4">Harga</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" placeholder="Harga Barang" wire:model="price">

                                @error('price')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
