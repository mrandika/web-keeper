@section('page')
{{ $warehouse->name }}
@endsection

@section('js-head')
    <script src="https://maps.google.com/maps/api/js?key={{ env('GMAPS_API_KEY') }}"></script>
    <script src="{{ asset('js/gmaps.js') }}"></script>
@endsection

@extends('layouts.sidebar.admin-nav')

@section('warehouse-active')
    active
@endsection

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('warehouse.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Informasi Warehouse</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('superadmin.home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('warehouse.index') }}">Warehouse</a></div>
                <div class="breadcrumb-item">{{ $warehouse->name }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="{{ asset('image/warehouse.png') }}" class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Penyimpanan</div>
                                    <div class="profile-widget-item-value">{{ $warehouse->storages->count() }} slot</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Pegawai</div>
                                    <div class="profile-widget-item-value">{{ $warehouse->employees->count() }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Barang</div>
                                    <div class="profile-widget-item-value">{{ $warehouse->items->count() }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">{{ $warehouse->name }} <div class="text-muted d-inline font-weight-normal"><div class="slash"></div>
                                {{ $warehouse->user->data->fullname() }}</div></div>

                            {{ $warehouse->address }}

                            <div class="text-right mt-4">
                                <button class="btn btn-danger" wire:click="redirect_page('warehouse.destroy', '{{ $warehouse->id }}')">Hapus</button>
                                <button class="btn btn-warning" wire:click="redirect_page('warehouse.edit', '{{ $warehouse->id }}')">Perbarui</button>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Lokasi Map</h4>
                        </div>
                        <div class="card-body">
                            <div id="map" class="p-5" data-height="300"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Barang</h4>
                        </div>

                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @forelse($warehouse->items as $item)
                                    <li class="media" wire:click="redirect_page('warehouse.show', '{{ $item->id }}')">
                                        <img class="mr-3 rounded" width="55" src="{{ asset('image/package.png') }}" alt="{{ $item->name }}">
                                        <div class="media-body">
                                            <div class="float-right">
                                                <div class="font-weight-600 text-muted text-small">
                                                    Stock: {{ $item->stock }}

                                                    @if ($item->stock >= 100)
                                                        <i class="fas fa-circle" style="color: green"></i>
                                                    @elseif($item->stock > 25 && $item->stock <= 50)
                                                        <i class="fas fa-circle" style="color: orange"></i>
                                                    @elseif($item->stock <= 25)
                                                        <i class="fas fa-circle" style="color: red"></i>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="media-title">{{ $item->name }}</div>
                                            <div class="media-subtitle">SKU: {{ $item->sku }}</div>
                                            <div class="media-subtitle">Rp. {{ $item->price }}</div>
                                        </div>
                                    </li>
                                @empty
                                    @livewire('component.state.unknown-state', [
                                        'title' => 'Tidak ada barang di warehouse ini',
                                        'subtitle' => 'Warehouse ini belum mempunyai barang, klik tombol dibawah untuk memulai membuat barang.',
                                        'primary_button_dest' => route('warehouse.create'),
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

@section('js')
    <script>
        $(document).on('turbolinks:load', function () {
            var map = new GMaps({
                div: '#map',
                lat: {{ $warehouse->latitude }},
                lng: {{ $warehouse->longitude }}
            });

            map.addMarker({
                lat: {{ $warehouse->latitude }},
                lng: {{ $warehouse->longitude }},
                title: 'Warehouse'
            });
        })
    </script>
@endsection
