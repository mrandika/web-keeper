@section('page')
    Debit Transaction
@endsection

@extends('layouts.sidebar.admin-nav')

@section('pos-active')
    active
@endsection

@section('pos-db-active')
    active
@endsection

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pembelian</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('superadmin.home') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Buat Pembelian</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Pembelian</h4>
                        </div>
                        <div class="card-body">
                            @if(session('buy_success'))
                                <div class="alert alert-success alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>×</span>
                                        </button>
                                        {{ session('buy_success') }}
                                    </div>
                                </div>
                            @endif

                            @if(session('buy_error'))
                                <div class="alert alert-danger alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>×</span>
                                        </button>
                                        {{ session('buy_error') }}
                                    </div>
                                </div>
                            @endif

                            <form wire:submit.prevent="add_to_cart">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="barang_select">Barang</label>
                                        <select id="barang_select" class="form-control" wire:model="item_id" wire:change="on_item_selected">
                                            <option value="0" selected disabled>Pilih Barang</option>
                                            @foreach($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @if ($item_id != '0')
                                        <div class="form-group col-md-4">
                                            <label for="storage_select">Lokasi Penyimpanan</label>
                                            <select id="storage_select" class="form-control" wire:model="storage_id" wire:change="on_storage_selected">
                                                <option value="0" selected disabled>Pilih Lokasi</option>
                                                @foreach($locations as $location)
                                                    <option value="{{ $location->warehouse_storage_id }}">{{ $location->storage->row->code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    @if ($storage_id != '0')
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">Kuantitas</label>
                                            <input min="1" type="number" class="form-control" wire:model="qty">
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <div class="card-footer">
                            <div class="text-right">
                                <button class="btn btn-primary" wire:click="add_to_cart">Tambah</button>
                            </div>
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
