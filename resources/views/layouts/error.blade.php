@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container mt-5">
            <div class="page-error">
                <div class="page-inner">
                    <h1>{{ session()->get('info')['code'] ?? '404' }}</h1>
                    <div class="page-description">
                        {{ session()->get('info')['message'] ?? 'Halaman tidak ditemukan!' }}
                    </div>
                    <div class="page-search">
                        <div class="mt-3">
                            <a href="{{ session()->get('info')['back_url'] ?? route('home') }}">Kembali ke Home</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-footer mt-5">
                Copyright &copy; Keeper {{ date('Y') }}
            </div>
        </div>
    </section>
@endsection
