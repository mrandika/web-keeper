<?php

namespace App\Http\Livewire\SuperAdmin;

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
        return view('livewire.super-admin.dashboard-view')
            ->extends('layouts.dashboard')
            ->section('main');
    }
}
