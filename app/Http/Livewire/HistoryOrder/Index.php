<?php

namespace App\Http\Livewire\HistoryOrder;

use Carbon\Carbon;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
// use App\Enums\OrderStatusEnum;

class Index extends Component
{
    use WithPagination;

    // public function mount()
    // {
    //     $this->data = Order::latest()->get();
    // }

    protected $listeners = ['refreshOrderTable' => '$refresh'];

    public function render()
    {
        return view('livewire.history-order.index', [
            // 'data' => Order::latest()->simplePaginate(5),
            // 'data' => Order::where('user_id', auth()->user()->id)->whereDate('created_at', Carbon::today())->latest()->simplePaginate(25)->latest(),
            // 'data' => Order::findOrFail(2)->whereDate('created_at', Carbon::today())->latest()->simplePaginate(25),
            // 'data' => DB::table('orders')->select('orders.*')->where('user_id', auth()->user()->id)->whereDate('created_at', Carbon::today())->latest(),
            'data' => Order::where('user_id', auth()->user()->id)->whereDate('created_at', Carbon::today())->latest()->simplePaginate(10),
        ]);
    }

    // public function repeat($id)
    // {
    //     //Todo: repeating sms to customer
    // }

    // public function done($id)
    // {
    //     //Todo: done sms to customer
    // }

    // public function done($id)
    // {
    //     return Order::findOrFail($id)->update([
    //         'status' => OrderStatusEnum::COMPLETED,
    //     ]);
    // }

    // public function repeat($id)
    // {
    //     $order = Order::where('user_id', auth()->id())->findOr($id, function () {
    //         session()->flash('alert', 'Data ga ada.');
    //         return back();
    //     });
    // }
}
