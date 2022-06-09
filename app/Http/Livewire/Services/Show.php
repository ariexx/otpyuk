<?php

namespace App\Http\Livewire\Services;

use Livewire\Component;

class Show extends Component
{
    public $service;
    public function mount($service)
    {
        $this->service = $service;
    }
    public function render()
    {
        return view('livewire.services.show');
    }
}
