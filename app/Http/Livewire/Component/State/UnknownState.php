<?php

namespace App\Http\Livewire\Component\State;

use Illuminate\View\View;
use Livewire\Component;

class UnknownState extends Component
{
    public $title, $subtitle, $primary_button_dest, $primary_button_text;

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        return view('livewire.component.state.unknown-state');
    }
}
