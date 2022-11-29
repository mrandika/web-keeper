@section('page')
    {{ $item->name }}
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
            <h1>Informasi Barang</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('superadmin.home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('item.index') }}">Item</a></div>
                <div class="breadcrumb-item">{{ $item->name }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="{{ asset('image/package.png') }}" class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Jumlah Penyimpanan</div>
                                    <div class="profile-widget-item-value">
                                        {{ $item->locations->count() }}
                                    </div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Total Stock</div>
                                    <div class="profile-widget-item-value">
                                        {{ $item->locations->pluck('stock')->sum() }}
                                    </div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Harga</div>
                                    <div class="profile-widget-item-value">
                                        Rp. {{ $item->price }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">{{ $item->name }} <div class="text-muted d-inline font-weight-normal"><div class="slash"></div>
                                    {{ $item->sku }}</div></div>

                            <div class="text-right mt-4">
                                <button class="btn btn-danger" wire:click="redirect_page('item.destroy', '{{ $item->id }}')">Hapus</button>
                                <button class="btn btn-warning" wire:click="redirect_page('item.edit', '{{ $item->id }}')">Perbarui</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lokasi Penyimpanan</h4>
                            <a href="{{ route('item.location.create', $item->id) }}" class="btn btn-primary">Tambah Baru</a>
                        </div>

                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @forelse($item->locations as $location)
                                    <li class="media">
                                        <img class="mr-3 rounded" width="55" src="{{ asset('image/storage.png') }}">
                                        <div class="media-body">
                                            <div class="float-right">
                                                <div class="font-weight-600 text-muted text-small">Stock: {{ $location->stock }}</div>
                                            </div>
                                            <div class="media-title">{{ $location->storage->aisle->warehouse->name }}</div>
                                            <div class="media-subtitle">Lorong {{ $location->storage->aisle->code }}</div>
                                            <div class="media-subtitle">Kolom {{ $location->storage->column->code }}</div>
                                            <div class="media-subtitle">Baris {{ $location->storage->row->code }}</div>
                                        </div>
                                    </li>
                                @empty
                                    @livewire('component.state.unknown-state', [
                                    'title' => 'Barang ini tidak disimpan pada warehouse manapun.',
                                    'subtitle' => 'Barang ini belum mempunyai lokasi penyimpanan, klik tombol dibawah untuk memulai membuat lokasi barang.',
                                    'primary_button_dest' => route('item.location.create', $item->id),
                                    'primary_button_text' => 'Buat Baru'
                                    ])
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
