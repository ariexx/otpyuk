<?php

use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Http;

if (!function_exists('rupiah')) {
    function rupiah($int)
    {
        $hasil_rupiah = "Rp " . number_format($int, 0, '', '.');
        return $hasil_rupiah;
    }
}

if (!function_exists('general_setting')) {
    function general_setting()
    {
        return app(GeneralSettings::class);
    }
}

if (!function_exists('push_order')) {
    function push_order($idProvider, $operatorId)
    {
        return Http::get(config('smshub.url'), [
            'api_key' => config('smshub.api_key'),
            'action' => 'getNumber',
            'service' => $idProvider,
            'operator' => $operatorId,
            'country' => '6'
        ])->body();
    }
}

if (!function_exists('changeStatusActivation')) {
    function changeStatusActivation($idOrder, ?int $status = null)
    {
        return Http::get(config('smshub.url'), [
            'api_key' => config('smshub.api_key'),
            'action' => 'setStatus',
            'status' => $status,
            'id' => $idOrder
        ])
            ->body();
    }
}
if (!function_exists('generateOrderId')) {
    function generateOrderId()
    {
        return now()->format('YmdHi') . random_int(1000, 9999);
    }
}

if (!function_exists('ResponseJsonSuccess')) {
    function ResponseJsonSuccess(?int $code, $message, $data = [])
    {
        return response()->json([
            'result' => [
                'code' => $code,
                'status' => true,
                'message' => $message,
                'data' => $data
            ]
        ], $code);
    }
}

if (!function_exists('ResponseJsonError')) {
    function ResponseJsonError(?int $code, $message)
    {
        return response()->json([
            'result' => [
                'code' => $code,
                'status' => false,
                'message' => $message,
            ]
        ], $code);
    }
}
