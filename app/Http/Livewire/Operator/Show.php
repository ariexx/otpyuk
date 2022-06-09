<?php

namespace App\Http\Livewire\Operator;

use Livewire\Component;

class Show extends Component
{
    public $operator;

    public function mount($operator)
    {
        $this->operator = $operator;
    }

    public function render()
    {
        return view('livewire.operator.show');
    }
}
