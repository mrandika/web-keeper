@section('page')
    Create Item
@endsection

@extends('layouts.sidebar')

@section('item-active')
    active
@endsection

<div class="main-content" wire:init="edit">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('item.show', $item_id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Perbarui Data Lokasi Barang</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('item.show', $item_id) }}">{{ $item->name }}</a></div>
                <div class="breadcrumb-item">Perbarui Penyimpanan {{ $location->storage->row->code }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="section-body">
                <form wire:submit.prevent="update">
                    <div class="card">
                        <div class="card-header">
                            <h4>Location Data</h4>
                        </div>

                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                <li class="media">
                                    <img class="mr-3 rounded" width="55" src="{{ asset('image/package.png') }}"
                                         alt="{{ $item->name }}">
                                    <div class="media-body">
                                        <div class="float-right">
                                            <div class="font-weight-600 text-muted text-small">
                                                @php
                                                    $stock = $item->locations->pluck('stock')->sum()
                                                @endphp

                                                Stock: {{ $stock }}

                                                @if ($stock > 50)
                                                    <i class="fas fa-circle" style="color: green"></i>
                                                @elseif($stock > 25 && $stock <= 50)
                                                    <i class="fas fa-circle" style="color: orange"></i>
                                                @elseif($stock <= 25)
                                                    <i class="fas fa-circle" style="color: red"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="media-title">{{ $item->name }}</div>
                                        <div class="media-subtitle">SKU: {{ $item->sku }}</div>
                                        <div class="media-subtitle">@currency($item->price)</div>
                                    </div>
                                </li>
                            </ul>

                            <div class="form-group">
                                <label for="inputPassword4">Stock</label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                       placeholder="Stock Barang" wire:model="stock">

                                @error('stock')
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
