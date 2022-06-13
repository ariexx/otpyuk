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
        $idOrder = Order::query()->where('id', $id)->value('provider_order_id');
        // $cancelActivation = file_get_contents(env('SMSHUB_URL') . '?api_key=' . env('SMSHUB_API_KEY') . '&action=setStatus&status=8&id=' . $idOrder);
        $cancelActivation = file_get_contents('https://smshub.org/stubs/handler_api.php?api_key=129471Ue15a55422c86f266e9116852521df6f5&action=setStatus&status=8&id=' . $idOrder);
        switch ($cancelActivation) {
            case 'ACCESS_CANCEL':
                User::findOrFail(auth()->user()->id)->update([
                    'balance' => User::findOrFail(auth()->user()->id)->balance + Order::findOrFail($id)->service->price,
                ]);
                Order::findOrFail($id)->update([
                    'status' => OrderStatusEnum::CANCELED,
                ]);
                return $this->alert('success', 'Success Cancel Order!');
                break;
            case 'ACCESS_READY':
                return $this->alert('success', 'SMS Waiting');
                break;
            case 'ACCESS_RETRY_GET':
                return $this->alert('error', 'We expect a new SMS!');
                break;
            case 'ACCESS_ACTIVATION':
                return $this->alert('error', 'Activation completed successfully!');
                break;
            default:
                return $this->alert('error', 'Something went wrong!');
                break;
        }
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

        $this->emit('refreshOrderTable');
    }

    public function render()
    {
        return view('livewire.history-order.show');
    }
}
