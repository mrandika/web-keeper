<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class ResetPasswordView extends Component
{
    public $email;

    public function render()
    {
        return view('livewire.auth.reset-password-view')
            ->extends('layouts.auth')
            ->section('auth-content');
    }

    public function redirect_page(string $route_name)
    {
        return redirect()->route($route_name);
    }

    public function reset_fields()
    {
        $this->email = '';
    }

    public function flash_message(string $key, string $value)
    {
        session()->flash($key, $value);
    }

    public function send_reset()
    {
        $this->validate([
            'email' => ['required', 'email', 'min:10'],
        ]);

        $this->reset_fields();
        $this->flash_message('info', 'Email berisi link pengaturan ulang kata sandi telah dikirim. Periksa kotak masuk email anda.');
    }
}
