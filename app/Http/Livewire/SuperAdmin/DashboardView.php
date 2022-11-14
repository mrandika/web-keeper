<?php

namespace App\Http\Livewire\SuperAdmin;

use Livewire\Component;

class DashboardView extends Component
{
    public function render()
    {
        return view('livewire.super-admin.dashboard-view')
            ->extends('layouts.dashboard')
            ->section('main');
    }
}
