<?php

namespace App\Http\Livewire\Order;

use App\Models\User;
use App\Models\Order;
use App\Models\Service;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Enums\OrderStatusEnum;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class InstantOrder extends Component
{
    use LivewireAlert;
    // public Order $order;
    public $serviceId = 1;
    protected $listeners = ['servicesId'];

    public function servicesId($id)
    {
        $this->serviceId = $id;
    }

    public function mount(Order $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.order.instant-order');
    }

    public function rules()
    {
        return [
            'serviceId' => 'required|integer',
        ];
    }

    public function instantOrder()
    {
        $this->validate();
        if ($this->user->findOrFail(auth()->user()->id)->balance < Service::findOrFail($this->serviceId)->price) {
            return $this->alert('error', 'Saldo Tidak Mencukupi', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        }

        $this->order::create([
            'user_id' => auth()->user()->id,
            'operator_id' => '6',
            'service_id' => $this->serviceId,
            'provider_order_id' => Str::random(10),
            'order_id' => Str::random(10),
            'phone_number' => Str::random(10),
            'sms_message' => '',
            'status' => OrderStatusEnum::PENDING,
            'start_at' => now(),
            'expires_at' => now()->addMinutes(env('MINUTES_TO_EXPIRE_ORDER'))
        ]);

        $this->user->findOrFail(auth()->user()->id)->update([
            'balance' => $this->user->findOrFail(auth()->user()->id)->balance - Service::findOrFail($this->serviceId)->price,
        ]);

        $this->emit('refreshOrderTable');
    }
}
