<?php

namespace App\Http\Livewire\Services;

use App\Models\Service;
use Livewire\Component;

class Index extends Component
{
    public $data;
    public $servicesId = '';

    public function updatedServicesId()
    {
        $this->emit('servicesId', $this->servicesId);
    }

    public function mount()
    {
        $this->data = Service::query()->where('is_active', 1)->get();
    }

    public function render()
    {
        return view('livewire.services.index');
    }
}
