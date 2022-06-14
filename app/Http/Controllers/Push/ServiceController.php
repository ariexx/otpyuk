<?php

namespace App\Http\Controllers\Push;

use App\Models\Rate;
use App\Models\Service;
// use Illuminate\Support\Arr;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Http;

class ServiceController extends Controller
{
    public function rateUpdate()
    {
        $setting = new GeneralSettings;
        $getPricesProvider = Http::withHeaders([
            "Content-Type" => "text/plain",
            "apikey" => "qcVvWj8Jgyf1TDEEp3qnRYLvtrYyvUG1"
        ])->get('https://api.apilayer.com/fixer/convert?to=IDR&from=RUB&amount=1')->json();
        if ($setting->rate == round($getPricesProvider['result'])) {
            return response()->message(true, 'Rate is Up to Date');
        }
        if ($getPricesProvider['success'] == true) {
            $setting->rate = $getPricesProvider['result'];
            if ($setting->save()) {
                return response()->message(true, 'Berhasil update rate ke database');
            }
        }
        return response()->message(false, 'API Error');
    }

    public function index()
    {
        $getServicesProvider = Http::get('https://smshub.org/stubs/handler_api.php', [
            'api_key' => '128886U4c885c93e42ae70b34f54fec12e830fd',
            'action' => 'getNumbersStatusAndCostHubFree',
        ])->json();

        $getListOfCountriesAndOperators = Http::get('http://smshub.org/api.php', [
            'cat' => 'scripts',
            'act' => 'manageActivations',
            'asc' => 'getListOfCountriesAndOperators',
        ])->json();

        $data = [];
        $getProviderPrices = Rate::where('id', 1)->first();
        foreach ($getServicesProvider as $key1 => $value1) {
            // dd(array_key_last($value1['priceMap']));
            foreach ($getListOfCountriesAndOperators['services'] as $key2 => $value2) {
                if ($key1 == $key2) {
                    // $lastPrices = array_key_last($value1['priceMap']);
                    $providerPrices = $value1['defaultPrice'] * $getProviderPrices->rate;
                    $calculatePrices = (($providerPrices * $getProviderPrices->profit) / 100);
                    $prices = $providerPrices + $calculatePrices;
                    // dd($lastPrices);
                    if ($value1['defaultPrice'] != "0" && $value1['work'] != false) {
                        $data[] = [
                            'provider_id' => $key1,
                            'operator_id' => 1,
                            'rate_id' => 1,
                            'service_name' => $value2,
                            'provider_price' => $providerPrices,
                            'price' =>  round($prices),
                            'discount' => 0,
                            'discount_percentage' => '0',
                            'is_active' => 1
                        ];
                    }
                    $data[] = [
                        'provider_id' => $key1,
                        'operator_id' => 1,
                        'rate_id' => 1,
                        'service_name' => $value2,
                        'provider_price' => $providerPrices,
                        'price' =>  round($prices),
                        'discount' => 0,
                        'discount_percentage' => '0',
                        'is_active' => 0
                    ];
                }
            }
        }
        // Service::query()->insertOrIgnore($data);
        $update = Service::query()->upsert(
            $data,
            ['provider_id'], //jadi ini gada gunanya
            ['provider_id', 'provider_price', 'price']
        );

        if ($update > 0) {
            return response()->message(true, 'Data berhasil diupdate sejumlah ' . $update . ' data');
        } else {
            return response()->message(false,  'Tidak ada data yang diupdate.');
        }
    }
}


// public function index()
//     {
//         $getPricesProvider = Http::get('https://free.currconv.com/api/v7/convert?q=RUB_IDR&compact=ultra&apiKey=c2fdb1217aed0df60310')->json();
//         $getServicesProvider = Http::get('https://smshub.org/stubs/handler_api.php?api_key=128886U4c885c93e42ae70b34f54fec12e830fd&action=getNumbersStatusAndCostHubFree')->json();
//         $providerPrices = $getPricesProvider->RUB_IDR;
//         Rate::where('id', 1)->update(['rate' => $providerPrices]);
//         // $servicesProviderArray = [];
//         // $servicesProviderArray['data'] = [];
//         // $service = DB::table('services')->first();
//         foreach ($getServicesProvider as $k => $v) {
//             if ($v['maxPrice'] != "0" && $v['work'] != false) {
//                 // $saveToArrayServices = [
//                 //     $k => [
//                 //         'prices' => [
//                 //             'min_price' => array_key_last($v['priceMap']),
//                 //             'max_price' => $v['maxPrice'],
//                 //         ],
//                 //     ],
//                 // ];
//                 // //push the array
//                 // array_push($servicesProviderArray['data'], $saveToArrayServices);

//                 $insertToDatabase = Service::create([
//                     'provider_id' => $k,
//                     'operator_id' => 1,
//                     'rate_id' => 1,
//                     'service_name' => $k,
//                     'provider_price' => $v['maxPrice'] * $providerPrices,
//                     'price' => $v['maxPrice'],
//                     'discount' => 'tidak',
//                     'discount_percentage' => '0',
//                     'is_active' => 'iya'
//                 ]);
//             }
//         }
//         if ($insertToDatabase) {
//             echo "Successfully inserted to database";
//         } else {
//             echo "Failed to insert to database";
//         }
//         //turn into json
//         // echo json_encode($servicesProviderArray);
//     }
