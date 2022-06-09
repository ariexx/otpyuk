<?php
$req_url = 'https://api.exchangerate.host/convert?from=RUBEL&to=IDR';
$response_json = file_get_contents($req_url);
if (false !== $response_json) {
    try {
        $response = json_decode($response_json);
        if ($response->success === true) {
            print_r($response);
        }
    } catch (Exception $e) {
        // Handle JSON parse error...
    }
}
