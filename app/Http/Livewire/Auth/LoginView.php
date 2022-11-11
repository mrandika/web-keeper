<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class LoginView extends Component
{
    public $email, $password, $remember = false;

    public function render()
    {
        return view('livewire.auth.login-view')
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
        $this->password = '';
        $this->remember = '';
    }

    public function flash_message(string $key, string $value)
    {
        session()->flash($key, $value);
    }

    public function login()
    {
        $this->validate([
            'email' => ['required', 'email', 'min:10'],
            'password' => ['required', Password::min(8)->letters()->numbers()->symbols()->mixedCase()],
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->redirect_page('home');
            $this->reset_fields();
        } else {
            $this->flash_message('info', 'Alamat email atau password tidak ditemukan. Pastikan anda memasukan alamat email dan password dengan benar.');
        }
    }
}
