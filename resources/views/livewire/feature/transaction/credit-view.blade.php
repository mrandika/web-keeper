@section('page')
    Debit Transaction
@endsection

@extends('layouts.sidebar.admin-nav')

@section('pos-active')
    active
@endsection

@section('pos-cr-active')
    active
@endsection

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Penjualan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Buat Penjualan</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Penjualan</h4>
                        </div>
                        <div class="card-body">
                            @if(session('sell_success'))
                                <div class="alert alert-success alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>×</span>
                                        </button>
                                        {{ session('sell_success') }}
                                    </div>
                                </div>
                            @endif

                            @if(session('sell_error'))
                                <div class="alert alert-danger alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>×</span>
                                        </button>
                                        {{ session('sell_error') }}
                                    </div>
                                </div>
                            @endif

                            <div class="float-right">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search" wire:model.debounce.500ms="search_value">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix mb-3"></div>

                            <ul class="list-unstyled list-unstyled-border">
                                @forelse($items as $item)
                                    <li class="media">
                                        <img class="mr-3 rounded" width="55" src="{{ asset('image/package.png') }}" alt="{{ $item->name }}">
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

                                                    <br>
                                                    <button class="btn btn-outline-primary @if($storage_id == null || $storage_id == '0') disabled @endif" wire:click="add_to_cart('{{ $item->id }}')">Tambah</button>
                                                </div>
                                            </div>
                                            <div class="media-title">{{ $item->name }}</div>
                                            <div class="media-subtitle">SKU: {{ $item->sku }}</div>
                                            <div class="media-subtitle">Rp. {{ $item->price }}</div>
                                            <div>
                                                <label for="inputState">Lokasi Penyimpanan</label>
                                                <select id="inputState" class="form-control" wire:model="storage_id" wire:change="on_storage_selected">
                                                    <option value="0" selected disabled>Pilih Lokasi</option>
                                                    @foreach($item->locations as $location)
                                                        <option value="{{ $location->warehouse_storage_id }}">{{ $location->storage->row->code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    @livewire('component.state.unknown-state', [
                                    'title' => 'Tidak ada data yang cocok',
                                    'subtitle' => 'Tidak ada data yang cocok dengan kata pencarian anda',
                                    'primary_button_dest' => route('item.create'),
                                    'primary_button_text' => 'Buat Baru'
                                    ])
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Summary</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @forelse($cart as $item)
                                    <li class="media">
                                        <img class="mr-3 rounded-circle" width="50" src="{{ asset('image/package.png') }}" alt="avatar">
                                        <div class="media-body">
                                            <div class="float-right text-primary">@ Rp. {{ $item['item']['price'] }}</div>
                                            <div class="media-title">{{ $item['item']['name'] }}</div>
                                            <span class="text-small">{{ $item['qty'] }}x,  Rp. {{ $item['item']['price'] * $item['qty'] }}</span>

                                            <div class="text-right">
                                                <button class="btn btn-sm btn-outline-primary" wire:click="qty('add', '{{ $item['item']['id'] }}')">+ Tambah</button>
                                                <button class="btn btn-sm btn-outline-secondary" wire:click="qty('sub', '{{ $item['item']['id'] }}')">- Kurangi</button>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    @livewire('component.state.unknown-state', [
                                    'title' => 'Belum ada barang di keranjang.',
                                    'subtitle' => 'Tambahkan barang pada data pembelian.'
                                    ])
                                @endforelse
                            </ul>
                        </div>

                        @if ($cart != [])
                            <div class="card-footer">
                                <div class="text-right">
                                    <button class="btn btn-primary" wire:click="checkout" wire:loading.class="btn-progress">Checkout</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>