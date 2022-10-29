<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class LoginView extends Component
{
    public $email, $password;

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
    }

    public function login()
    {
        $this->validate([
            'email' => ['required', 'email', 'min:10'],
            'password' => ['required', Password::min(8)->letters()->numbers()->symbols()->mixedCase()],
        ]);

        $this->reset_fields();
    }
}
