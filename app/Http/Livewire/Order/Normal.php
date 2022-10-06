<?php

namespace App\Http\Livewire\Order;

use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Enums\OrderStatusEnum;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Normal extends Component
{
    use LivewireAlert;
    // public Order $order;
    public $serviceId = 1;
    public $operatorId = 1;
    public $userId;
    protected $listeners = ['servicesId', 'operatorId'];

    public function servicesId($id)
    {
        $this->serviceId = $id;
    }

    public function operatorId($id)
    {
        $this->operatorId = $id;
    }

    public function mount(Order $order, User $user, Service $service)
    {
        $this->order = $order;
        $this->user = $user;
        $this->service = $service;
        $this->userId = auth()->user()->id;
    }

    public function rules()
    {
        return [
            'serviceId' => 'required|integer|exists:services,id',
            'operatorId' => 'required|integer|exists:operators,id',
        ];
    }

    public function render()
    {
        return view('livewire.order.normal');
    }

    public function normalOrder()
    {
        $this->validate();

        $balance = $this->user->getBalance($this->userId);
        $price = $this->service->getPrice($this->serviceId);

        if ($balance < $price) {
            Log::alert('Saldo provider tidak cukup');
            return $this->alert('error', 'Saldo Tidak Mencukupi');
        }

        $idProvider = $this->service->getProviderId($this->serviceId);
        $order = push_order($idProvider,   $this->operatorId);
        switch ($order) {
            case 'NO_NUMBERS':
                Log::alert("Response : " . $order);
                $this->alert('error', 'No Numbers Available!');
                break;
            case 'NO_BALANCE':
                Log::alert('Balance Not Enough : ' . $order);
                $this->alert('error', 'Contact Admin!');
                break;
            case 'WRONG_SERVICE':
                Log::alert('Wrong Service : ' . $order);
                $this->alert('error', 'Service Not Found!');
                break;
            case 'BAD_SERVICE':
                Log::alert('Wrong Service : ' . $order);
                $this->alert('error', 'Service Not Found!');
                break;
            case 'MAIL_RULE':
                Log::alert('Mail Rule : ' . $order);
                $this->alert('error', 'Contact Admin!');
                break;
            case 'BAD_ACTION':
                Log::alert('Bad Action : ' . $order);
                $this->alert('error', 'Contact Admin!');
                break;
            case 'BAD_KEY':
                Log::alert('Bad Key : ' . $order);
                $this->alert('error', 'Contact Admin!');
                break;
            case 'ERROR_SQL':
                Log::alert('Error SQL : ' . $order);
                $this->alert('error', 'Contact Admin!');
                break;
            default:
                $explode = explode(':', $order);

                $idOrder = $explode[1];
                $number = $explode[2];

                $this->order::create([
                    'user_id' => $this->userId,
                    'operator_id' => $this->operatorId,
                    'service_id' => $this->serviceId,
                    'provider_order_id' => $idOrder,
                    'order_id' => generateOrderId(),
                    'phone_number' => $number,
                    'present_sms_message' => '',
                    'sms_message' => '',
                    'status' => OrderStatusEnum::PENDING,
                    'start_at' => now(),
                    'expires_at' => now()->addMinutes(config('smshub.timeout'))
                ]);

                $this->user
                    ->findOrFail($this->userId)
                    ->update([
                        'balance' => $balance - $price,
                    ]);
                break;
        }
        $this->emit('refreshOrderTable');
    }
}
