<?php

namespace App\Http\Livewire\HistoryOrder;

use App\Models\Order;
use Livewire\Component;

class User extends Component
{
    public $search;
    protected $queryString = ['search'];

    public function render()
    {
        $orders = Order::search($this->search)->where('user_id', auth()->user()->id)->paginate(1);
        return view('livewire.history-order.user', compact('orders'));
    }
}
