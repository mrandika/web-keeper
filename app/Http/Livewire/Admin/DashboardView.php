<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class DashboardView extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard-view')
            ->extends('layouts.dashboard')
            ->section('main');
    }
}
