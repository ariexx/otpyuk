<?php

namespace App\Http\Livewire\Operator;

use App\Models\Operator;
use Livewire\Component;

class Index extends Component
{
    public $data;
    public $operatorId = '';

    public function updatedOperatorId()
    {
        $this->emit('operatorId', $this->operatorId);
    }

    public function mount()
    {
        $this->data = Operator::query()->select('id', 'operator_name')->get();
    }

    public function render()
    {
        return view('livewire.operator.index');
    }
}
