<?php

namespace App\Http\Livewire\HistoryOrder;

use App\Models\User;
use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Enums\OrderStatusEnum;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Show extends Component
{
    use LivewireAlert;
    public $history;
    public function mount($history)
    {
        $this->history = $history;
    }

    public function done($id)
    {
        $this->emit('refreshOrderTable');
        return Order::findOrFail($id)->update([
            'status' => OrderStatusEnum::COMPLETED,
        ]);
    }

    public function repeat($id)
    {
        $this->emit('refreshOrderTable');
        $smsLama = Order::findOrFail($id)->sms_message;
        return Order::findOrFail($id)->update([
            'status' => OrderStatusEnum::REPEAT,
            'sms_message' => implode(',', [$smsLama, Str::random(10)]),
            // 'sms_message' => '',
        ]);
    }

    public function cancel($id)
    {
        $this->emit('refreshOrderTable');
        if (Order::findOrFail($id)->expires_at->isPast()) {
            User::findOrFail(auth()->user()->id)->update([
                'balance' => User::findOrFail(auth()->user()->id)->balance + Order::findOrFail($id)->service->price,
            ]);
            return $this->alert('error', 'Order Sudah Expired', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        }

        User::findOrFail(auth()->user()->id)->update([
            'balance' => User::findOrFail(auth()->user()->id)->balance + Order::findOrFail($id)->service->price,
        ]);

        return Order::findOrFail($id)->update([
            'status' => OrderStatusEnum::CANCELED,
        ]);
    }

    public function render()
    {
        return view('livewire.history-order.show');
    }
}
