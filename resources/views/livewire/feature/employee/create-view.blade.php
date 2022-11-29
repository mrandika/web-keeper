@section('page')
    Create Employee
@endsection

@extends('layouts.sidebar.admin-nav')

@section('employee-active')
    active
@endsection

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('employee.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Buat Pegawai</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('superadmin.home') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Employee</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-4 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Users</h4>
                        </div>
                        <div class="card-body">
                            <div class="float-right">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search" wire:model.debounce.500ms="search_user">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix mb-3"></div>

                            <ul class="list-unstyled list-unstyled-border">
                                @forelse($users as $user)
                                    <li class="media" wire:click="select_user('{{ $user->id }}')">
                                        <img class="mr-3 rounded" width="55" src="{{ asset('image/avatar-1.png') }}" alt="{{ $user->data->fullname() }}">
                                        <div class="media-body">
                                            <div class="float-right"><div class="font-weight-600 text-muted text-small">{{ $user->email }}</div></div>
                                            <div class="media-title">{{ $user->data->fullname() }}</div>
                                            <div class="media-subtitle">Not Assigned</div>
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
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>

                <div class="col-4 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Warehouse</h4>
                        </div>
                        <div class="card-body">
                            <div class="float-right">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search" wire:model.debounce.500ms="search_warehouse">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix mb-3"></div>

                            <ul class="list-unstyled list-unstyled-border">
                                @forelse($warehouses as $warehouse)
                                    <li class="media" wire:click="select_warehouse('{{ $warehouse->id }}')">
                                        <img class="mr-3 rounded" width="55" src="{{ asset('image/warehouse.png') }}" alt="{{ $warehouse->name }}">
                                        <div class="media-body">
                                            <div class="float-right"><div class="font-weight-600 text-muted text-small">{{ '-' }} sales</div></div>
                                            <div class="media-title">{{ $warehouse->name }}</div>
                                            <div class="media-subtitle">{{ $warehouse->address }}</div>
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
                    </div>
                </div>

                <div class="col-4 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Summary</h4>
                        </div>
                        <div class="card-body">
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

                            <ul class="list-unstyled list-unstyled-border">
                                @isset($selected_user)
                                    <li class="media" wire:click="select_user('{{ $selected_user->id }}')">
                                        <img class="mr-3 rounded" width="55" src="{{ asset('image/avatar-1.png') }}" alt="{{ $selected_user->data->fullname() }}">
                                        <div class="media-body">
                                            <div class="float-right"><div class="font-weight-600 text-muted text-small">{{ $selected_user->email }}</div></div>
                                            <div class="media-title">{{ $selected_user->data->fullname() }}</div>
                                            <div class="media-subtitle">Not Assigned</div>
                                        </div>
                                    </li>
                                @endisset

                                @isset($selected_warehouse)
                                    <li class="media">
                                        <img class="mr-3 rounded" width="55" src="{{ asset('image/warehouse.png') }}" alt="{{ $selected_warehouse->name }}">
                                        <div class="media-body">
                                            <div class="float-right"><div class="font-weight-600 text-muted text-small">{{ '-' }} sales</div></div>
                                            <div class="media-title">{{ $selected_warehouse->name }}</div>
                                            <div class="media-subtitle">{{ $selected_warehouse->address }}</div>
                                        </div>
                                    </li>
                                @endisset
                            </ul>

                            @if($selected_user && $selected_warehouse)
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control select2 select2-hidden-accessible" wire:model="role_id">
                                        <option value="0" disabled selected>Pilih Role</option>
                                        <option value="{{ \App\Models\UserRole::where('name', 'Admin')->first()->id }}">Admin</option>
                                        <option value="{{ \App\Models\UserRole::where('name', 'Employee')->first()->id }}">Pegawai</option>
                                    </select>
                                </div>
                            @else
                                <div class="empty-state" data-height="400">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-question"></i>
                                    </div>
                                    <h2>Data pegawai dan warehouse kosong.</h2>
                                    <p class="lead">
                                        Untuk melakukan assignment pegawai, silahkan pilih data pegawai dan warehouse terlebih dulu.
                                    </p>
                                </div>
                            @endif
                        </div>

                        @if($selected_user && $selected_warehouse)
                            <div class="card-footer text-right">
                                <button class="btn btn-primary" wire:click="store" wire:loading.class="btn-progress">Simpan</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
