<?php

namespace App\Http\Livewire\Admin;

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
        return view('livewire.admin.dashboard-view')
            ->extends('layouts.dashboard')
            ->section('main');
    }
}
