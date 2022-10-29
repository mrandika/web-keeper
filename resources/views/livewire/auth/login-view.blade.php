@section('page')
    Login
@endsection

@section('subtitle')
    Untuk memulai, silahkan masuk menggunakan akun anda.
@endsection

<div>
    <form wire:submit.prevent="login" class="needs-validation" novalidate="">
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" tabindex="1" wire:model="email" required autofocus>

            @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <div class="d-block">
                <label for="password" class="control-label">Kata Sandi</label>
            </div>
            <input id="password" type="password" class="form-control @error('email') is-invalid @enderror" name="password" tabindex="2" wire:model="password" required>

            @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group text-right">
            <a href="#" wire:click="redirect_page('auth.reset-password')" class="float-left mt-3">
                Lupa Kata Sandi?
            </a>
            <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" wire:loading.class="btn-progress" tabindex="4">
                Masuk
            </button>
        </div>

        <div class="mt-5 text-center">
            Belum punya akun? <a href="#" wire:click="redirect_page('auth.register')">Buat baru</a>
        </div>
    </form>
</div>
