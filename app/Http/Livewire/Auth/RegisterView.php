<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class RegisterView extends Component
{
    public $first_name, $last_name, $phone_number;
    public $email, $password, $password_confirmation;

    public function render()
    {
        return view('livewire.auth.register-view')
            ->extends('layouts.auth')
            ->section('auth-content');;
    }

    public function redirect_page(string $route_name)
    {
        return redirect()->route($route_name);
    }

    public function reset_fields()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->phone_number = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function register()
    {
        $this->validate([
            'first_name' => ['required', 'min:5'],
            'last_name' => ['required', 'min:5'],
            'phone_number' => ['required', 'min:10'],
            'email' => ['required', 'email', 'min:10'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()->mixedCase()],
        ]);

        $this->reset_fields();
    }
}
