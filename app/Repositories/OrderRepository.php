<?php

namespace App\Repositories;

use App\Http\Resources\OrderCheckResource;
use App\Http\Resources\OrderResource;
use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use App\Models\Operator;
use Illuminate\Support\Facades\Log;

/**
 * Class OrderRepository.
 */
class OrderRepository
{
    protected $model;
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    /*
    ** Store data to database
    ** @param array $data
    ** @return object
    Order Status :
        ** 0 = REPEAT
        ** 1 = PROCESSING
        ** 2 = COMPLETED
        ** 3 = CANCELED
        ** 4 = PENDING
    */
    public function store($data)
    {
        //get user id from apikey
        $user = User::where('apikey', $data['apikey'])->first();
        //get service id from service_id
        $service = Service::where('provider_id', $data['service_id'])->first();
        //get operator id from operator_id
        $operator = Operator::where('operator_name', $data['operator_id'])->first();

        //check balance user can buy service
        if ($user->balance < $service->price) {
            return ResponseJsonError(400, "Saldo anda tidak cukup!");
        }

        //update balance of user
        $user->balance = $user->balance - $service->price;
        $user->save();


        $order = push_order($data['service_id'], $data['operator_id']);
        Log::info('Log dari repository order : ' . $order . ' Param ' . json_encode($data) . ' at ' . __FILE__ . ' line ' . __LINE__);

        switch ($order) {
            case 'NO_NUMBERS':
                return ResponseJsonError(400, __('messages.error.no_numbers'));
                break;
            case 'NO_BALANCE':
                Log::alert('Error order api : ' . "Saldo smshub habis : " . ' code ' . $order .  ' at ' . __FILE__ . ' line ' . __LINE__ . ' trace ' . json_encode($data));
                return ResponseJsonError(400, "Kontak admin!");
                break;
            case 'WRONG_SERVICE':
                Log::alert('Error order api : ' . "Service tidak ditemukan : " . ' code ' . $order .  ' at ' . __FILE__ . ' line ' . __LINE__ . ' trace ' . json_encode($data));
                return ResponseJsonError(400, "Service tidak ditemukan!");
                break;
        }

        //explode result success of order
        $result = explode(':', $order);
        $provider_order_id = $result[1];
        $provider_number = $result[2];

        //store data to database
        $model = $this->model->create(
            [
                'user_id' => $user->id,
                'service_id' => $service->id,
                'operator_id' => $operator->id,
                'provider_order_id' => $provider_order_id,
                'order_id' => generateOrderId(),
                'phone_number' => $provider_number,
                'present_sms_message' => '',
                'sms_message' => '',
                'start_at' => now(),
                'expires_at' => now()->addMinutes(env('MINUTES_TO_EXPIRE_ORDER', 20)),
                'status' => 1,
                'created_at' => now(),
            ]
        );
        return new OrderResource($model);
    }

    public function check($data)
    {
        $order = $this->model->with('service:id,service_name')->where('order_id', $data['order_id'])->firstOrFail();
        if (!$order) {
            return ResponseJsonError(400, __('not-found', ['name' => 'Order']));
        }
        return ResponseJsonSuccess(200, __('messages.success.get', ['name' => 'Order']), new OrderCheckResource($order));
    }

    /**
     * @param data
     * @return object
     * @status 0 = REPEAT
     * @status 1 = PROCESSING
     * @status 2 = COMPLETED
     * @status 3 = CANCELED
     * @status 4 = PENDING
     */
    public function update($data)
    {
        $order = $this->model->where('order_id', $data['order_id'])->first();
        if (!$order) {
            return ResponseJsonError(400, __('not-found', ['name' => 'Order']));
        }

        $status = changeStatusActivation($order->provider_order_id, $data['status']);
        switch ($status) {
            case 'SMS_READY':
                $order->status = 1;
                $order->save();
                break;
            case 'ACCESS_RETRY_GET':
                $order->status = 0;
                $order->save();
                break;
            case 'ACCESS_ACTIVATION':
                $order->status = 2;
                $order->save();
                break;
            case 'ACCESS_CANCEL':
                $order->status = 3;
                $order->save();
                //update balance of user if status cancel
                $user = User::where('id', $order->user_id)->first();
                $user->balance = $user->balance + $order->service->price;
                $user->save();
                break;
            case 'BAD_ACTION':
                Log::alert('Error order api : ' . "Action tidak ditemukan : " . ' code ' . $status .  ' at ' . __FILE__ . ' line ' . __LINE__ . ' trace ' . json_encode($data));
                return ResponseJsonError(400, "Action tidak ditemukan!");
                break;
            case 'BAD_SERVICE':
                Log::alert('Error order api : ' . "Service tidak ditemukan : " . ' code ' . $status .  ' at ' . __FILE__ . ' line ' . __LINE__ . ' trace ' . json_encode($data));
                return ResponseJsonError(400, "Service tidak ditemukan!");
                break;
            case 'BAD_KEY':
                Log::alert('Error order api : ' . "Key tidak ditemukan : " . ' code ' . $status .  ' at ' . __FILE__ . ' line ' . __LINE__ . ' trace ' . json_encode($data));
                return ResponseJsonError(400, "Kontak Admin!");
                break;
            case 'NO_ACTIVATION':
                Log::alert('Error order api : ' . "Tidak ada aktivasi : " . ' code ' . $status .  ' at ' . __FILE__ . ' line ' . __LINE__ . ' trace ' . json_encode($data));
                return ResponseJsonError(400, "Tidak ada aktivasi!");
                break;
            case 'ERROR_SQL':
                Log::alert('Error order api : ' . "Terjadi kesalahan pada database : " . ' code ' . $status .  ' at ' . __FILE__ . ' line ' . __LINE__ . ' trace ' . json_encode($data));
                return ResponseJsonError(400, "Terjadi kesalahan pada database!");
                break;
        }

        return ResponseJsonSuccess(200, __('messages.success.update', ['name' => 'Order']), new OrderResource($order));
    }
}
