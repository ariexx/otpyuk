<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class HistoryOrderController extends Controller
{

    public function index()
    {
        $orders = Order::all();
        return view('orders.history-order', compact('orders'));
    }
}
