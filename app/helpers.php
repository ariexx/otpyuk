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

if (!function_exists('get_http_request')) {
}

if (!function_exists('general_setting')) {
    function general_setting()
    {
        return app(GeneralSettings::class);
    }
}


function push_order($idProvider, $operatorId)
{
    return Http::get(env('SMSHUB_URL'), [
        'api_key' => env('PROVIDERS_APIKEY'),
        'action' => 'getNumber',
        'service' => $idProvider,
        'operator' => $operatorId,
        'country' => '6'
    ])->body();
}

function changeStatusActivation($idOrder, ?int $status = null)
{
    return Http::get(env('SMSHUB_URL'), [
        'api_key' => env('PROVIDERS_APIKEY'),
        'action' => 'setStatus',
        'status' => $status,
        'id' => $idOrder
    ]);

    // $completedActivation = file_get_contents('' . env('SMSHUB_URL') . '?api_key=' . env('PROVIDERS_APIKEY') . '&action=setStatus&status=6&id=' . $idOrder);
}
