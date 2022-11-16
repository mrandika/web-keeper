<?php

namespace App\Http\Livewire\Component\State;

use Livewire\Component;

class UnknownState extends Component
{
    public $title, $subtitle, $primary_button_dest, $primary_button_text;

    public function render()
    {
        return view('livewire.component.state.unknown-state');
    }
}
