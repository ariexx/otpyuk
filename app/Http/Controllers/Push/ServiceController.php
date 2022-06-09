<?php

namespace App\Http\Controllers\Push;

use App\Models\Rate;
use App\Models\Service;
// use Illuminate\Support\Arr;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ServiceController extends Controller
{
    public function rateUpdate()
    {
        $getPricesProvider = Http::get('https://free.currconv.com/api/v7/convert?q=RUB_IDR&compact=ultra&apiKey=c2fdb1217aed0df60310')->json();
        $update = Rate::where('id', 1)->update(['rate' => $getPricesProvider['RUB_IDR']]);
        if ($update) {
            return response()->json(['success' => true, 'message' => 'Rate berhasil diupdate']);
        } else {
            return response()->json(['success' => false, 'message' => 'Rate gagal diupdate']);
        }
    }

    public function index()
    {
        $getServicesProvider = Http::get('https://smshub.org/stubs/handler_api.php?api_key=128886U4c885c93e42ae70b34f54fec12e830fd&action=getNumbersStatusAndCostHubFree')->json();
        $getProviderPrices = Rate::where('id', 1)->first();
        foreach ($getServicesProvider as $k => $v) {
            if ($v['maxPrice'] != "0" && $v['work'] != false) {
                $providerPrices = $v['maxPrice'] * $getProviderPrices->rate;
                $calculatePrices = (($providerPrices * $getProviderPrices->profit) / 100);
                $prices = $providerPrices + $calculatePrices;
                $insertToDatabase = Service::create([
                    'provider_id' => $k,
                    'operator_id' => 1,
                    'rate_id' => 1,
                    'service_name' => $k,
                    'provider_price' => $providerPrices,
                    'price' => $prices,
                    'discount' => 'tidak',
                    'discount_percentage' => '0',
                    'is_active' => 'iya'
                ]);
            }
        }
        if ($insertToDatabase) {
            echo "Successfully inserted to database";
        } else {
            echo "Failed to insert to database";
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
