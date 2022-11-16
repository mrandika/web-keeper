@section('page')
    New Warehouse
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
            <h1>Buat Warehouse Baru</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('superadmin.home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('warehouse.index') }}">Warehouse</a></div>
                <div class="breadcrumb-item">Tambah Baru</div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Warehouse</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mt-4">
                            <div class="col-12 col-lg-8 offset-lg-2">
                                <div class="wizard-steps">
                                    <div class="wizard-step wizard-step">
                                        <div class="wizard-step-icon">
                                            <i class="far fa-warehouse"></i>
                                        </div>
                                        <div class="wizard-step-label">
                                            Informasi Dasar
                                        </div>
                                    </div>
                                    <div class="wizard-step">
                                        <div class="wizard-step-icon">
                                            <i class="fas fa-database"></i>
                                        </div>
                                        <div class="wizard-step-label">
                                            Informasi Penyimpanan
                                        </div>
                                    </div>
                                    <div class="wizard-step wizard-step-active">
                                        <div class="wizard-step-icon">
                                            <i class="fas fa-info"></i>
                                        </div>
                                        <div class="wizard-step-label">
                                            Ringkasan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wizard-content mt-2">
                            <div class="wizard-pane">
                                <div class="form-group row align-items-center">
                                    <label class="col-md-4 text-md-right text-left">Pemilik</label>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="text" class="form-control" value="{{ $warehouse->user->data->fullname() }} ({{ $warehouse->user->email }})" readonly disabled>
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label class="col-md-4 text-md-right text-left">Nama Warehouse</label>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="text" class="form-control" value="{{ $warehouse->name }}" readonly disabled>
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label class="col-md-4 text-md-right text-left">Alamat Warehouse</label>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="text" class="form-control" value="{{ $warehouse->address }}" readonly disabled>
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label class="col-md-4 text-md-right text-left">Jumlah Total Penyimpanan</label>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="text" class="form-control" value="{{ $warehouse->storages->count() }}" readonly disabled>
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label class="col-md-4 text-md-right text-left">Lokasi Warehouse</label>
                                    <div class="col-lg-4 col-md-6">
                                        <div id="map" data-height="200"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4"></div>
                                    <div class="col-lg-4 col-md-6 text-right">
                                        <button wire:click="redirect_page('warehouse.index')" class="btn btn-icon icon-right btn-primary">Selesai</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@section('js')
    <script>
        $(document).on('turbolinks:load',function () {
            var map = new GMaps({
                div: '#map',
                lat: @this.get('lat'),
                lng: @this.get('long')
            });

            map.addMarker({
                lat: @this.get('lat'),
                lng: @this.get('long'),
                title: 'Warehouse'
            });
        })
    </script>
@endsection
