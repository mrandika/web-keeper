<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardPartialView extends Component
{
    public function render()
    {
        return view('livewire.dashboard.dashboard-partial-view')
            ->extends('layouts.app')
            ->section('content');
    }

    public function redirect_page(string $route_name)
    {
        return redirect()->route($route_name);
    }

    public function logout()
    {
        Auth::logout();

        $this->redirect_page('auth.login');
    }
}
