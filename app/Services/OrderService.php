<?php

namespace App\Services;

use Response;
use Exception;
use App\Models\Order;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Validator;

class OrderService
{
    protected $repo;
    public function __construct(OrderRepository $repo)
    {
        $this->repo = $repo;
    }

    public function store($data)
    {
        $validator = Validator::make(
            $data,
            [
                'apikey' => 'required|exists:users,apikey',
                'operator_id' => 'required|exists:operators,operator_name',
                'service_id' => 'required|exists:services,provider_id'
            ],
            [
                'apikey.required' => __('Apikey diperlukan'),
                'apikey.exists' => __('Apikey tidak ada'),
                'operator_id.required' => __('Operator id diperlukan'),
                'operator_id.exists' => __('Operator id tidak ada'),
                'service_id.required' => __('Service id diperlukan'),
                'service_id.exists' => __('Service id tidak ada')
            ]
        );

        if ($validator->fails()) {
            Log::alert(
                'Error order api : ' . $validator->errors()->first() .
                    ' at ' . __FILE__ .
                    ' line ' . __LINE__ .
                    ' trace ' . json_encode($data)
            );
            return ResponseJsonError(400, $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $result = $this->repo->store($data);
        } catch (InvalidArgumentException $e) {
            DB::rollBack();
            Log::alert(
                'Error order api : ' . $e->getMessage() .
                    ' at ' . $e->getFile() .
                    ' line ' . $e->getLine() .
                    ' trace ' . $e->getTraceAsString() .
                    ' code ' . $e->getCode()
            );
            return ResponseJsonError(400, $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            Log::alert(
                'Error order api : ' . $e->getMessage() .
                    ' at ' . $e->getFile() .
                    ' line ' . $e->getLine() .
                    ' trace ' . $e->getTraceAsString() .
                    ' code ' . $e->getCode()
            );
            return ResponseJsonError(500, __('api.error.500'));
        }
        DB::commit();
        return $result;
    }

    public function check($data)
    {
        $validator = Validator::make(
            $data,
            [
                'type' => 'required|in:check',
                'apikey' => 'required|exists:users,apikey',
                'order_id' => 'required|exists:orders,order_id'
            ],
            [
                'type.required' => __('Tipe diperlukan'),
                'type.in' => __('Tipe tidak valid'),
                'apikey.required' => __('Apikey diperlukan'),
                'apikey.exists' => __('Apikey tidak ada'),
                'order_id.required' => __('Order id diperlukan'),
                'order_id.exists' => __('Order id tidak ada')
            ]
        );

        if ($validator->fails()) {
            Log::alert(
                'Error check order api : ' . $validator->errors()->first() .
                    ' at ' . __FILE__ .
                    ' line ' . __LINE__ .
                    ' trace ' . json_encode($data)
            );
            return ResponseJsonError(400, $validator->errors()->first());
        }

        try {
            $result = $this->repo->check($data);
        } catch (InvalidArgumentException $e) {
            Log::alert(
                'Error check order api : ' . $e->getMessage() .
                    ' at ' . $e->getFile() .
                    ' line ' . $e->getLine() .
                    ' trace ' . $e->getTraceAsString() .
                    ' code ' . $e->getCode()
            );
            return ResponseJsonError(400, $e->getMessage());
        } catch (Exception $e) {
            Log::alert(
                'Error check order api : ' . $e->getMessage() .
                    ' at ' . $e->getFile() .
                    ' line ' . $e->getLine() .
                    ' trace ' . $e->getTraceAsString() .
                    ' code ' . $e->getCode()
            );
            return ResponseJsonError(500, __('api.error.500'));
        }
        return $result;
    }

    public function update($data)
    {
        $validator = Validator::make($data, [
            'type' => 'required|in:set_status',
            'apikey' => 'required|exists:users,apikey',
            'order_id' => 'required|exists:orders,order_id',
            'status' => 'required|in:8,3,6',
        ], [
            'type.required' => __('Tipe diperlukan'),
            'type.in' => __('Tipe tidak valid'),
            'apikey.required' => __('Apikey diperlukan'),
            'apikey.exists' => __('Apikey tidak ada'),
            'order_id.required' => __('Order id diperlukan'),
            'order_id.exists' => __('Order id tidak ada'),
            'status.required' => __('Status diperlukan'),
            'status.in' => __('Status tidak valid'),
        ]);

        if ($validator->fails()) {
            Log::alert(
                'Error update order api : ' . $validator->errors()->first() .
                    ' at ' . __FILE__ .
                    ' line ' . __LINE__ .
                    ' trace ' . json_encode($data)
            );
            return ResponseJsonError(400, $validator->errors()->first());
        }

        $order = Order::where('order_id', $data['order_id'])->firstOrFail();
        if ($order->status->value == 3) {
            return ResponseJsonError(403, __('Status order sudah dibatalkan'));
        }

        try {
            $result = $this->repo->update($data);
        } catch (InvalidArgumentException $e) {
            Log::alert(
                'Error update order api : ' . $e->getMessage() .
                    ' at ' . $e->getFile() .
                    ' line ' . $e->getLine() .
                    ' trace ' . $e->getTraceAsString() .
                    ' code ' . $e->getCode()
            );
            $result = ResponseJsonError(400, $e->getMessage());
        } catch (Exception $e) {
            Log::alert(
                'Error update order api : ' . $e->getMessage() .
                    ' at ' . $e->getFile() .
                    ' line ' . $e->getLine() .
                    ' trace ' . $e->getTraceAsString() .
                    ' code ' . $e->getCode()
            );
            $result = ResponseJsonError(500, __('api.error.500'));
        }
        return $result;
    }
}
