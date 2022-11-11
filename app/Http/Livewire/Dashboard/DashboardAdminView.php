<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class DashboardAdminView extends Component
{
    public function render()
    {
        return view('livewire.dashboard.dashboard-admin-view')
            ->extends('livewire.dashboard.dashboard-partial-view')
            ->section('dashboard-content');
    }
}
