<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Enums\OrderStatusEnum;
use Illuminate\Console\Command;

class OrderCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking all status of orders';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Order::select('*')->where('status', '<>', OrderStatusEnum::COMPLETED)->get();
        foreach ($orders as $order) {
            $getStatusOrder = file_get_contents('https://smshub.org/stubs/handler_api.php?api_key=' . env('PROVIDERS_APIKEY') . '&action=getStatus&id=' . $order->provider_order_id);
            $explodeStatus = explode(':', $getStatusOrder);
            info('Check Order id: ' . $order->id . ' - Provider Id ' . $order->provider_order_id . ' - status: ' . $explodeStatus[0]);
            switch ($getStatusOrder) {
                case $explodeStatus[0] == 'STATUS_OK':
                    $order->update([
                        'status' => OrderStatusEnum::PROCESSING,
                        'sms_message' => $explodeStatus[1],
                    ]);
                    break;
                case 'STATUS_WAIT_CODE':
                    $order->update([
                        'status' => OrderStatusEnum::PENDING,
                    ]);
                    break;
                case 'STATUS_CANCEL':
                    $order->update([
                        'status' => OrderStatusEnum::CANCELED,
                    ]);
                    break;
                case $explodeStatus[0] == 'STATUS_WAIT_RETRY':
                    $order->update([
                        'status' => OrderStatusEnum::REPEAT,
                        'sms_message' => implode(':', [$order->sms_message, $explodeStatus[1]]),
                    ]);
                    break;
                default:
                    info($getStatusOrder . ' Order ID: ' . $order->id);
                    break;
            }
        }
        info('Checking all status of orders');
    }
}
