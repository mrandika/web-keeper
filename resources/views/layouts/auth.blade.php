@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="d-flex flex-wrap align-items-stretch">
            <div class="col-lg-4 col-md-6 col-12 order-lg-2 min-vh-100 order-1 bg-white">
                <div class="p-4 m-3">
                    <img src="{{ asset('image/img-keeper.png') }}" alt="logo" width="80" class="shadow-light rounded-circle mb-5 mt-2">
                    <h4 class="text-dark font-weight-normal">Selamat datang di <span class="font-weight-bold">{{ config('app.name') }}</span></h4>
                    <p class="text-muted">@yield('subtitle')</p>

                    @yield('auth-content')

                    <div class="text-center mt-5 text-small">
                        Copyright &copy; {{ config('app.name') }}. Tampilan oleh Stisla.
                        <div class="mt-2">
                            <a href="#">Kebijakan Privasi</a>
                            <div class="bullet"></div>
                            <a href="#">Ketentuan Layanan</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-12 order-lg-1 order-2 min-vh-100 position-relative overlay-gradient-bottom" style="background-image: url({{ asset('image/auth-banner.png') }}); background-size: cover;">
                <div class="absolute-bottom-left index-2">
                    <div class="text-light p-5 pb-2">
                        <div class="mb-5 pb-3">
                            <h1 class="mb-2 display-4 font-weight-bold">Keeper<br>Warehouse Management System</h1>
                            <h5 class="font-weight-normal text-muted-transparent">Version: {{ env('APP_VERSION') ?? '1.0.0' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
