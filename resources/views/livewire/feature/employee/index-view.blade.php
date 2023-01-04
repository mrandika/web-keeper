@section('page')
    Warehouse
@endsection

@extends('layouts.sidebar')

@section('employee-active')
    active
@endsection

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pegawai</h1>
            <div class="section-header-button">
                <a href="{{ route('employee.create') }}" class="btn btn-primary">Tambah Baru</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Employee</div>
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
                                            class="badge badge-white">{{ $employees->count() }}</span></a>
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
                            <h4>All Employee</h4>
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
                                @forelse($employees as $employee)
                                    <li class="media"
                                        wire:click="redirect_page('employee.show', '{{ $employee->id }}')">
                                        <img class="mr-3 rounded" width="55" src="{{ asset('image/avatar-1.png') }}"
                                             alt="{{ $employee->user->data->fullname() }}">
                                        <div class="media-body">
                                            <div class="float-right">
                                                <div
                                                    class="font-weight-600 text-muted text-small">{{ $employee->user->email }}</div>
                                            </div>
                                            <div class="media-title">{{ $employee->user->data->fullname() }}</div>
                                            <div class="media-subtitle">{{ $employee->warehouse->name }}</div>
                                        </div>
                                    </li>
                                @empty
                                    @livewire('component.state.unknown-state', [
                                    'title' => 'Tidak ada data yang cocok',
                                    'subtitle' => 'Tidak ada data yang cocok dengan kata pencarian anda',
                                    'primary_button_dest' => route('employee.create'),
                                    'primary_button_text' => 'Buat Baru'
                                    ])
                                @endforelse
                            </ul>
                        </div>

                        <div class="card-footer text-right">
                            {{ $employees->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
