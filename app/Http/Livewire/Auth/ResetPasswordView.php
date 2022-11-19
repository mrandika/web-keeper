<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;

class ResetPasswordView extends Component
{
    public $email;

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        return view('livewire.auth.reset-password-view')
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
     * Send a password reset email to a user
     *
     * @return RedirectResponse
     */
    public function send_reset()
    {
        $this->validate([
            'email' => ['required', 'email', 'min:10'],
        ]);

        $this->reset_fields();
        $this->redirect_page('auth.login');
        $this->flash_message('info', 'Email berisi link pengaturan ulang kata sandi telah dikirim. Periksa kotak masuk email anda.');
    }
}
