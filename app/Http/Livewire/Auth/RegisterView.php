<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use App\Models\UserData;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            ->section('auth-content');
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

    public function flash_message(string $key, string $value)
    {
        session()->flash($key, $value);
    }

    public function register()
    {
        $this->validate([
            'first_name' => ['required', 'min:5'],
            'last_name' => ['required', 'min:5'],
            'phone_number' => ['required', 'unique:user_data', 'min:10'],
            'email' => ['required', 'email', 'min:10'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()->mixedCase()],
        ]);

        DB::transaction(function () {
            $user = new User();
            $user->email = $this->email;
            $user->password = Hash::make($this->password);
            $user->user_role_id = UserRole::where('name', 'Employee')->first()->id;
            $user->save();

            $data = new UserData();
            $data->user_id = $user->id;
            $data->first_name = $this->first_name;
            $data->last_name = $this->last_name;
            $data->phone_number = $this->phone_number;
            $data->save();
        });

        $this->reset_fields();
        $this->redirect_page('auth.login');
        $this->flash_message('info', 'Akun berhasil terdaftar. Periksa kembali setelah akun anda dikonfirmasi.');
    }
}
