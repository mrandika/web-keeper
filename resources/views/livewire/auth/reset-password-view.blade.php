@section('page')
    Reset Password
@endsection

@section('subtitle')
    Silahkan masukan email anda, kami akan mengirimkan tautan untuk mengatur ulang kata sandi anda.
@endsection

<div>
    @if(session('info'))
        <div class="alert alert-light alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>×</span>
                </button>
                {{ session('info') }}
            </div>
        </div>
    @endif

    <form wire:submit.prevent="send_reset" class="needs-validation" novalidate="">
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" tabindex="1" wire:model="email" required autofocus>

            @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" wire:loading.class="btn-progress" tabindex="2">
                Kirim Email
            </button>
        </div>

        <div class="mt-5 text-center">
            Sudah mengatur ulang kata sandi? <a href="#" wire:click="redirect_page('auth.login')">Masuk</a>
        </div>
    </form>
</div>
