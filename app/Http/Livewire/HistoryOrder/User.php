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
        $orders = Order::search($this->search)->query(function ($builder) {
            $builder->with(['service:id,service_name']);
        })->where('user_id', auth()->id())->paginate(10);

        return view('livewire.history-order.user', compact('orders'));
    }
}
