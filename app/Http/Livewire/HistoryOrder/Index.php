<?php

namespace App\Http\Livewire\HistoryOrder;

use App\Enums\OrderStatusEnum;
use Carbon\Carbon;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
// use App\Enums\OrderStatusEnum;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['refreshOrderTable' => '$refresh'];

    public function render()
    {
        return view('livewire.history-order.index', [
            // 'data' => Order::latest()->simplePaginate(5),
            // 'data' => Order::search($this->search)->where('user_id', auth()->user()->id)->where('created_at', Carbon::today())->paginate(10),
            // 'data' => Order::findOrFail(2)->whereDate('created_at', Carbon::today())->latest()->simplePaginate(25),
            // 'data' => DB::table('orders')->select('orders.*')->where('user_id', auth()->user()->id)->whereDate('created_at', Carbon::today())->latest(),
            'data' =>
            Order::query()
                ->where('user_id', auth()->user()->id)
                ->startWasExpired()
                ->whereNot('status', OrderStatusEnum::COMPLETED)
                ->whereDate('created_at', Carbon::today())->latest()->paginate(10),
        ]);
    }
}
