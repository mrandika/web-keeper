<?php

namespace App\Http\Livewire\Employee;

use Livewire\Component;

class DashboardView extends Component
{
    public function render()
    {
        return view('livewire.employee.dashboard-view')
            ->extends('layouts.dashboard')
            ->section('main');
    }
}
