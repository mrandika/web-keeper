@section('page')
    Warehouse
@endsection

@extends('layouts.sidebar')

@section('warehouse-active')
    active
@endsection

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Warehouse</h1>
            @if(auth()->user()->role->name == 'Super-Admin')
                <div class="section-header-button">
                    <a href="{{ route('warehouse.create') }}" class="btn btn-primary">Tambah Baru</a>
                </div>
            @endif
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Warehouse</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">Semua <span
                                            class="badge badge-white">{{ $warehouses->count() }}</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                {{ session('info') }}
                            </div>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h4>All Warehouse</h4>
                        </div>
                        <div class="card-body">
                            <div class="float-right">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search"
                                           wire:model.debounce.500ms="search_value">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix mb-3"></div>

                            <ul class="list-unstyled list-unstyled-border">
                                @forelse($warehouses as $warehouse)
                                    <li class="media"
                                        wire:click="redirect_page('warehouse.show', '{{ $warehouse->id }}')">
                                        <img class="mr-3 rounded" width="55" src="{{ asset('image/warehouse.png') }}"
                                             alt="{{ $warehouse->name }}">
                                        <div class="media-body">
                                            <div class="float-right">
                                                <div class="font-weight-600 text-muted text-small">{{ "-" }} Sales</div>
                                            </div>
                                            <div class="media-title">{{ $warehouse->name }}</div>
                                            <div class="media-subtitle">{{ $warehouse->address }}</div>
                                        </div>
                                    </li>
                                @empty
                                    @livewire('component.state.unknown-state', [
                                    'title' => 'Tidak ada data yang cocok',
                                    'subtitle' => 'Tidak ada data yang cocok dengan kata pencarian anda',
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
