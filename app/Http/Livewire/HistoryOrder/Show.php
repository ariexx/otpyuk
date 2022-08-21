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
    public $user;
    public $order;

    public function mount($history, User $user, Order $order)
    {
        $this->history = $history;
        $this->user = $user;
        $this->order = $order;
    }

    public function done($id)
    {
        //confirm sms and completed activation
        $idOrder = $this->order->valueProviderOrderId($id);
        $completedActivation = changeStatusActivation($idOrder, '6'); //6 = completed
        switch ($completedActivation) {
            case 'ACCESS_READY':
                return $this->alert('success', 'SMS Waiting');
                break;
            case 'ACCESS_RETRY_GET':
                $smsLama = Order::findOrFail($id);
                $smsLama->update([
                    'status' => OrderStatusEnum::REPEAT,

                ]);
                return $this->alert('success', 'SMS direquest kembali!');
                break;
            case 'ACCESS_ACTIVATION':
                Order::findOrFail($id)->update([
                    'status' => OrderStatusEnum::COMPLETED,
                ]);
                return $this->alert('success', 'Activation completed successfully!');
                break;
            default:
                return $this->alert('error', 'Something went wrong!');
                break;
        }
        $this->emit('refreshOrderTable');
    }

    public function repeat($id)
    {
        //request another sms
        $idOrder = $this->order->valueProviderOrderId($id);
        $requestNewActivation = changeStatusActivation($idOrder, '3'); //3 = request new activation
        switch ($requestNewActivation) {
            case 'ACCESS_READY':
                return $this->alert('success', 'SMS Waiting');
                break;
            case 'ACCESS_RETRY_GET':
                $smsLama = Order::findOrFail($id);
                $smsLama->update([
                    'status' => OrderStatusEnum::REPEAT,

                ]);
                return $this->alert('success', 'SMS direquest kembali!');
                break;
            case 'ACCESS_ACTIVATION':
                return $this->alert('success', 'Activation completed successfully!');
                break;
            default:
                return $this->alert('error', 'Something went wrong!');
                break;
        }
        $this->emit('refreshOrderTable');
    }

    public function cancel($id)
    {
        $order = $this->order->where('id', $id)->first();
        $user = $this->user->where('id', $order->user_id)->first();

        $idOrder = $this->order->valueProviderOrderId($id);
        $cancelActivation = changeStatusActivation($idOrder, '8'); //8 = cancel activation
        switch ($cancelActivation) {
            case 'ACCESS_CANCEL':
                $this->user->findOrFail(auth()->id())
                    ->update([
                        'balance' => $user->balance + $order->service->price,
                    ]);
                $this->order->findOrFail($id)->update([
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
                return $this->alert('success', 'Activation completed successfully!');
                break;
            default:
                return $this->alert('error', 'Something went wrong!');
                break;
        }
        if ($order->expires_at->isPast()) {
            $this->user->findOrFail($user->id)->update([
                'balance' => $user->balance + $order->service->price,
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
        $this->emit('refreshOrderTable');
    }
}
