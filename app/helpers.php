<?php

use App\Settings\GeneralSettings;

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
