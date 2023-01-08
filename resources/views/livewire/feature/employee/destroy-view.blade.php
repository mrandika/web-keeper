@section('page')
    Hapus Pegawai
@endsection

@extends('layouts.sidebar')

@section('employee-active')
    active
@endsection

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('employee.show', $employee_id) }}" class="btn btn-icon"><i
                        class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Konfirmasi Penghapusan Pegawai</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('employee.index') }}">Pegawai</a></div>
                <div class="breadcrumb-item"><a
                        href="{{ route('employee.show', $employee_id) }}">{{ $employee->user->data->fullname() }}</a>
                </div>
                <div class="breadcrumb-item">Hapus</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="empty-state" data-height="400">
                        <div class="empty-state-icon" style="background-color: red">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <h2>Anda yakin menghapus data pegawai ini?</h2>
                        <p class="lead">
                            Data yang berkaitan dengan pegawai ini akan dihapus. Aksi ini <b>TIDAK DAPAT</b>
                            dikembalikan dan akan dicatat pada log sistem.
                        </p>
                        <a href="#" wire:click="destroy" class="btn btn-danger mt-4">Ya, hapus</a>

                        <a href="{{ route('employee.show', $employee_id) }}" class="mt-4 bb">Tidak, batalkan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
