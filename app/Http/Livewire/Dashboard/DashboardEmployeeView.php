<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class DashboardEmployeeView extends Component
{
    public function render()
    {
        return view('livewire.dashboard.dashboard-employee-view')
            ->extends('livewire.dashboard.dashboard-partial-view')
            ->section('dashboard-content');
    }
}
