<?php

namespace App\Http\Livewire\Employee;

use Illuminate\View\View;
use Livewire\Component;

class DashboardView extends Component
{
    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        return view('livewire.employee.dashboard-view')
            ->extends('layouts.dashboard')
            ->section('main');
    }
}
