<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class HistoryOrderController extends Controller
{

    public function index()
    {
        //parsing enums to string
        // $orders = Order::query()->where('user_id', auth()->user()->id)->get(); //refactor
        // return view('orders.history-order', compact('orders'));
        return view('orders.history-order');
    }
}
