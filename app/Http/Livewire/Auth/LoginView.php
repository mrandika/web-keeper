<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Livewire\Component;

class LoginView extends Component
{
    public $email, $password, $remember = false;

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        return view('livewire.auth.login-view')
            ->extends('layouts.auth')
            ->section('auth-content');
    }

    /**
     * Redirect to specified route name
     *
     * @param string $route_name    The route name declared on routing file
     *
     * @return RedirectResponse
     */
    public function redirect_page(string $route_name)
    {
        return redirect()->route($route_name);
    }

    /**
     * Reset this view form
     *
     * @return void
     */
    public function reset_fields()
    {
        $this->email = '';
        $this->password = '';
        $this->remember = '';
    }

    /**
     * Set flash message for this current session
     *
     * @return void
     */
    public function flash_message(string $key, string $value)
    {
        session()->flash($key, $value);
    }

    /**
     * Authenticate the users
     *
     * @return RedirectResponse
     */
    public function login()
    {
        $this->validate([
            'email' => ['required', 'email', 'min:10'],
            'password' => ['required', Password::min(8)->letters()->numbers()->symbols()->mixedCase()],
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->reset_fields();
            $this->redirect_page('home');
        } else {
            $this->flash_message('info', 'Alamat email atau password tidak ditemukan. Pastikan anda memasukan alamat email dan password dengan benar.');
        }
    }
}
