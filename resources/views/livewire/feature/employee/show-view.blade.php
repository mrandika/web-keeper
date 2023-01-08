@section('page')
    {{ $employee->user->data->fullname() }}
@endsection

@extends('layouts.sidebar')

@section('employee-active')
    active
@endsection

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('employee.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Informasi Pegawai</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('employee.index') }}">Pegawai</a></div>
                <div class="breadcrumb-item">{{ $employee->user->data->fullname() }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="{{ asset('image/avatar-1.png') }}"
                                 class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Status</div>
                                    <div class="profile-widget-item-value">
                                        <span
                                            class="badge badge-{{ $employee->status ? 'primary' : 'warning' }}">{{ $employee->status ? 'Aktif' : 'Tidak Aktif' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">{{ $employee->user->data->fullname() }}
                                <div class="text-muted d-inline font-weight-normal">
                                    <div class="slash"></div>
                                    {{ $employee->warehouse->name }}</div>
                            </div>

                            {{ $employee->user->email }} ({{ $employee->user->data->phone_number }})

                            <div class="text-right mt-4">
                                <button class="btn btn-danger"
                                        wire:click="redirect_page('employee.destroy', '{{ $employee->id }}')">Hapus
                                </button>
                                <button class="btn btn-warning"
                                        wire:click="redirect_page('employee.edit', '{{ $employee->id }}')">Perbarui
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
