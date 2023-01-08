@section('page')
    New Warehouse
@endsection

@extends('layouts.sidebar')

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
                                    <div class="wizard-step wizard-step">
                                        <div class="wizard-step-icon">
                                            <i class="far fa-warehouse"></i>
                                        </div>
                                        <div class="wizard-step-label">
                                            Informasi Dasar
                                        </div>
                                    </div>
                                    <div class="wizard-step wizard-step-active">
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

                        <form class="wizard-content mt-2 needs-validation" wire:submit.prevent="save_storage"
                              novalidate="">
                            <div class="wizard-pane">
                                <div class="form-group row align-items-center">
                                    <label class="col-md-4 text-md-right text-left">Kode</label>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="text" name="code"
                                               class="form-control @error('code') is-invalid @enderror"
                                               wire:model="code">

                                        @error('code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label class="col-md-4 text-md-right text-left">Jumlah Lorong</label>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="number" name="aisle"
                                               class="form-control @error('aisle') is-invalid @enderror"
                                               wire:model="aisle">

                                        @error('aisle')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label class="col-md-4 text-md-right text-left">Jumlah Kolom per Lorong</label>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="number" name="column"
                                               class="form-control @error('column') is-invalid @enderror"
                                               wire:model="column">

                                        @error('column')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label class="col-md-4 text-md-right text-left">Jumlah Baris per Kolom</label>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="number" name="row"
                                               class="form-control @error('row') is-invalid @enderror" wire:model="row">

                                        @error('row')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4"></div>
                                    <div class="col-lg-4 col-md-6 text-right">
                                        <button type="submit" class="btn btn-icon icon-right btn-primary"
                                                wire:loading.class="btn-progress">Selanjutnya <i
                                                class="fas fa-arrow-right"></i></button>
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
