<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Enums\OrderStatusEnum;

class Normal extends Component
{

    // public Order $order;
    public $serviceId = 1;
    public $operatorId = 1;
    protected $listeners = ['servicesId', 'operatorId'];

    public function servicesId($id)
    {
        $this->serviceId = $id;
    }

    public function operatorId($id)
    {
        $this->operatorId = $id;
    }

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function rules()
    {
        return [
            'serviceId' => 'required|integer',
            'operatorId' => 'required|integer',
        ];
    }

    public function render()
    {
        return view('livewire.order.normal');
    }

    public function normalOrder()
    {
        $this->validate();
        $this->order::create([
            'user_id' => auth()->user()->id,
            'operator_id' => $this->operatorId,
            'service_id' => $this->serviceId,
            'provider_order_id' => Str::random(10),
            'order_id' => Str::random(10),
            'phone_number' => Str::random(10),
            'sms_message' => '',
            'status' => OrderStatusEnum::PENDING,
            'start_at' => now(),
            'expires_at' => now()->addMinutes(env('MINUTES_TO_EXPIRE_ORDER'))
        ]);
        session()->flash('message', 'Order Placed.');
        $this->emit('refreshOrderTable');
    }
}
