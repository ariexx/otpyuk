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
        //confirm sms and completed activation
        $idOrder = Order::query()->where('id', $id)->value('provider_order_id');
        $completedActivation = file_get_contents('' . env('SMSHUB_URL') . '?api_key=' . env('PROVIDERS_APIKEY') . '&action=setStatus&status=6&id=' . $idOrder);

        switch ($completedActivation) {
            case 'ACCESS_READY':
                return $this->alert('success', 'SMS Waiting');
                break;
            case 'ACCESS_RETRY_GET':
                $smsLama = Order::findOrFail($id);
                $smsLama->update([
                    'status' => OrderStatusEnum::REPEAT,
                    // 'sms_message' => '',
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
        $idOrder = Order::query()->where('id', $id)->value('provider_order_id');
        $requestNewActivation = file_get_contents('' . env('SMSHUB_URL') . '?api_key=' . env('PROVIDERS_APIKEY') . '&action=setStatus&status=3&id=' . $idOrder);
        switch ($requestNewActivation) {
            case 'ACCESS_READY':
                return $this->alert('success', 'SMS Waiting');
                break;
            case 'ACCESS_RETRY_GET':
                $smsLama = Order::findOrFail($id);
                $smsLama->update([
                    'status' => OrderStatusEnum::REPEAT,
                    // 'sms_message' => '',
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
        $Order = Order::query()->where('id', $id)->first();
        $idOrder = Order::query()->where('id', $id)->value('provider_order_id');
        // $cancelActivation = file_get_contents(env('SMSHUB_URL') . '?api_key=' . env('SMSHUB_API_KEY') . '&action=setStatus&status=8&id=' . $idOrder);
        $cancelActivation = file_get_contents('' . env('SMSHUB_URL') . '?api_key=' . env('PROVIDERS_APIKEY') . '&action=setStatus&status=8&id=' . $idOrder);
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
                return $this->alert('success', 'Activation completed successfully!');
                break;
            default:
                return $this->alert('error', 'Something went wrong!');
                break;
        }
        if ($Order->expires_at->isPast() && $Order->status == OrderStatusEnum::PENDING) {
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
        $this->emit('refreshOrderTable');
    }
}
