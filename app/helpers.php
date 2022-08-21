<?php

use Illuminate\Support\Str;
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
        return Http::get(env('SMSHUB_URL'), [
            'api_key' => env('PROVIDERS_APIKEY'),
            'action' => 'getNumber',
            'service' => $idProvider,
            'operator' => $operatorId,
            'country' => '6'
        ], [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:102.0) Gecko/20100101 Firefox/102.0',
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        ])->body();
    }
}

if (!function_exists('changeStatusActivation')) {
    function changeStatusActivation($idOrder, ?int $status = null)
    {
        return Http::get(env('SMSHUB_URL'), [
            'api_key' => env('PROVIDERS_APIKEY'),
            'action' => 'setStatus',
            'status' => $status,
            'id' => $idOrder
        ], [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:102.0) Gecko/20100101 Firefox/102.0',
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        ])
            ->body();
    }
}
if (!function_exists('generateOrderId')) {
    function generateOrderId()
    {
        return now()->format('YmdHi') . rand(0000, 9999);
    }
}
