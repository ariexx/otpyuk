<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Services\ServiceService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    protected $service;

    public function __construct(ServiceService $service)
    {
        $this->service = $service;
    }

    public function getAll(Request $request)
    {
        $data = $request->only([
            'apikey'
        ]);
        try {
            $result = $this->service->getAll($data);
        } catch (Exception $e) {
            Log::critical("message: {$e->getMessage()}, code: {$e->getCode()}");
            return ResponseJsonError(404, __('not-found', ['name' => 'Service']));
        } catch (InvalidArgumentException $e) {
            return ResponseJsonError(500, $e->getMessage());
        }
        return $result;
    }
}
