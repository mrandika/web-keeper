@section('page')
    Perbarui Pegawai
@endsection

@extends('layouts.sidebar')

@section('employee-active')
    active
@endsection

<div class="main-content" wire:init="edit">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('employee.show', $employee_id) }}" class="btn btn-icon"><i
                        class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Perbarui Informasi Pegawai</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('employee.index') }}">Employee</a></div>
                <div class="breadcrumb-item"><a
                        href="{{ route('employee.show', $employee_id) }}">{{ $employee->user->data->fullname() }}</a>
                </div>
                <div class="breadcrumb-item">Perbarui</div>
            </div>
        </div>

        <div class="section-body">
            <form wire:submit.prevent="update">
                <div class="card">
                    <div class="card-header">
                        <h4>Employee Data</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Nama Depan</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       placeholder="Nama Depan" wire:model="first_name">

                                @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Nama Belakang</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                       placeholder="Nama Belakang" wire:model="last_name">

                                @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword4">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Email" wire:model="email">

                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="inputPassword4">Nomor Telepon</label>
                            <input type="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                                   placeholder="Nomor Telepon" wire:model="phone_number">

                            @error('phone_number')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Warehouse</label>
                            <select class="form-control" wire:model="warehouse_id" wire:change="change_warehouse">
                                <option value="0" selected disabled>Pilih Warehouse</option>

                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Peran Pengguna</label>
                            <select class="form-control" wire:model="user_role_id">
                                <option value="0" selected disabled>Pilih Peran Pengguna</option>
                                <option value="{{ \App\Models\UserRole::where('name', 'Super-Admin')->first()->id }}"
                                        disabled>Super-Admin
                                </option>
                                <option value="{{ \App\Models\UserRole::where('name', 'Admin')->first()->id }}">Admin
                                </option>
                                <option value="{{ \App\Models\UserRole::where('name', 'Employee')->first()->id }}">
                                    Employee
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status Akun</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="0" class="selectgroup-input"
                                           wire:model="status">
                                    <span class="selectgroup-button selectgroup-button-icon">Non-Aktif</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="1" class="selectgroup-input"
                                           wire:model="status">
                                    <span class="selectgroup-button selectgroup-button-icon">Aktif</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
