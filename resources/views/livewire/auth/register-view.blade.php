@section('page')
    Register
@endsection

@section('subtitle')
    Untuk memulai menggunakan aplikasi, silahkan daftarkan diri anda.
@endsection

<div>
    <form wire:submit.prevent="register" class="needs-validation" novalidate="">
        <div class="form-row">
            <div class="col">
                <div class="form-group">
                    <label for="first_name">Nama Depan</label>
                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" tabindex="1" wire:model="first_name" required autofocus>

                    @error('first_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="last_name">Nama Belakang</label>
                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" tabindex="2" wire:model="last_name" required>

                    @error('last_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="phone_number">Nomor Telepon</label>
            <input id="phone_number" type="tel" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" tabindex="3" wire:model="phone_number" required>

            @error('phone_number')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" tabindex="4" wire:model="email" required>

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
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" tabindex="5" wire:model="password" required>
            <small id="passwordHelpBlock" class="form-text text-muted">
                Kata sandi anda harus mempunyai panjang 8 karakter atau lebih, mengandung huruf, angka dan simbol, tidak mengandung spasi ataupun emoji.
            </small>

            @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <div class="d-block">
                <label for="password_confirmation" class="control-label">Konfirmasi Kata Sandi</label>
            </div>
            <input id="password_confirmation" type="password" class="form-control @error('password_confirm') is-invalid @enderror" name="password_confirmation" wire:model="password_confirmation" tabindex="5" required>

            @error('password_confirmation')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" wire:loading.class="btn-progress" tabindex="6">
                Daftar
            </button>
        </div>

        <div class="mt-5 text-center">
            Sudah punya akun? <a href="#" wire:click="redirect_page('auth.login')">Masuk</a>
        </div>
    </form>
</div>
