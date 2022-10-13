<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    protected $service;
    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }
    public function store(Request $request)
    {
        $data = $request->only(['apikey', 'operator_id', 'service_id']);
        try {
            $result = $this->service->store($data);
        } catch (Exception $e) {
            Log::alert(
                'Error order api : ' . $e->getMessage() . '
                at ' . $e->getFile() . '
                line ' . $e->getLine() . '
                trace ' . $e->getTraceAsString() . '
                code ' . $e->getCode()
            );
            $result = ResponseJsonError(500, __('api.error.500'));
        }
        return $result;
    }

    public function check(Request $request)
    {
        $data = $request->only(['type', 'apikey', 'order_id']);
        try {
            $result = $this->service->check($data);
        } catch (Exception $e) {
            Log::alert(
                'Error check order api : ' . $e->getMessage() . '
            at ' . $e->getFile() . '
            line ' . $e->getLine() . '
            trace ' . $e->getTraceAsString() . '
            code ' . $e->getCode()
            );
            return ResponseJsonError(500, __('api.error.500'));
        }
        return $result;
    }

    public function update(Request $request)
    {
        $data = $request->only(['type', 'apikey', 'order_id', 'status']);
        try {
            $result = $this->service->update($data);
        } catch (Exception $e) {
            Log::alert('Error update order api : ' . $e->getMessage() . '
            at ' . $e->getFile() . '
            line ' . $e->getLine() . '
            trace ' . $e->getTraceAsString() . '
            code ' . $e->getCode());

            $result = ResponseJsonError(500, __('api.error.500'));
        }
        return $result;
    }
}
