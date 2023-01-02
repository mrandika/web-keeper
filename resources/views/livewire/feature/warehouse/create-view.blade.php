@section('page')
    New Warehouse
@endsection

@section('js-head')
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
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
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
                                    <div class="wizard-step wizard-step-active">
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
                                    <div class="wizard-step">
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

                        <form class="wizard-content mt-2 needs-validation" wire:submit.prevent="save_basic" novalidate="">
                            <div class="wizard-pane">
                                <div class="form-group row align-items-center">
                                    <label class="col-md-4 text-md-right text-left">Nama</label>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="text" name="name" class="form-control @error('warehouse.name') is-invalid @enderror" wire:model="warehouse.name">

                                        @error('warehouse.name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-4 text-md-right text-left mt-2">Alamat</label>
                                    <div class="col-lg-4 col-md-6">
                                        <textarea id="loc-addr" class="form-control @error('warehouse.address') is-invalid @enderror" name="address" wire:model="warehouse.address"></textarea>

                                        @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row" id="loc-long-el">
                                    <label class="col-md-4 text-md-right text-left mt-2">Longitude</label>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="text" id="loc-long" class="form-control @error('warehouse.longitude') is-invalid @enderror" name="longitude" aria-describedby="longitude-desc" wire:model="warehouse.longitude">
                                        <small id="longitude-desc" class="form-text text-muted">Terisi otomatis oleh lokasi anda.</small>

                                        @error('warehouse.longitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row" id="loc-lat-el">
                                    <label class="col-md-4 text-md-right text-left mt-2">Latitude</label>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="text" id="loc-lat" class="form-control @error('warehouse.latitude') is-invalid @enderror" name="latitude" aria-describedby="latitude-desc" wire:model="warehouse.latitude">
                                        <small id="latitude-desc" class="form-text text-muted">Terisi otomatis oleh lokasi anda.</small>

                                        @error('warehouse.latitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4"></div>
                                    <div class="col-lg-4 col-md-6 text-right">
                                        <button type="submit" class="btn btn-icon icon-right btn-primary" wire:loading.class="btn-progress">Selanjutnya <i class="fas fa-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@section('js')
    <script>
        $(document).on('turbolinks:load', function () {
            GMaps.geolocate({
                success: function(position) {
                    if (position.coords.latitude) {
                    @this.set('warehouse.latitude', position.coords.latitude, true);
                        $("#loc-lat").val(position.coords.latitude);
                        $("#latitude-desc").text("Terisi otomatis oleh lokasi anda.");
                    }

                    if (position.coords.longitude) {
                    @this.set('warehouse.longitude', position.coords.longitude, true);
                        $("#loc-long").val(position.coords.longitude);
                        $("#longitude-desc").text("Terisi otomatis oleh lokasi anda.");
                    }
                },
                // when geolocation is blocked by the user
                error: function(error) {
                    console.error('Geolocation failed: '+error.message)
                    $("#latitude-desc").text("Akses ke lokasi ditolak. Gunakan Google Maps untuk mengambil data latitude.");
                    $("#longitude-desc").text("Akses ke lokasi ditolak. Gunakan Google Maps untuk mengambil data longitude.");
                },
                // when the user's browser does not support
                not_supported: function() {
                    console.error("Your browser does not support geolocation");
                    $("#latitude-desc").text("Gunakan Google Maps untuk mengambil data latitude.");
                    $("#longitude-desc").text("Gunakan Google Maps untuk mengambil data longitude.");
                }
            });
        });
    </script>
@endsection
