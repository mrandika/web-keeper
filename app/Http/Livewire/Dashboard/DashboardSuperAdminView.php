<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class DashboardSuperAdminView extends Component
{
    public function render()
    {
        return view('livewire.dashboard.dashboard-super-admin-view')
            ->extends('livewire.dashboard.dashboard-partial-view')
            ->section('dashboard-content');
    }
}
