<div>
    <div class="input mt-2 mb-2">
        <input type="text" class="form-control" wire:model="search" placeholder="Search">
    </div>
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Order ID</th>
                <th scope="col">Service Name</th>
                <th scope="col">Phone Number</th>
                <th scope="col">SMS Message</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                {{-- @dd($order); --}}
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->service->service_name }}</td>
                    <td>{{ $order->phone_number }}</td>
                    <td>{{ $order->sms_message }}</td>
                    <td>
                        @if ($order->status == \App\Enums\OrderStatusEnum::PENDING)
                            <span class="badge badge-warning">Menunggu...</span>
                        @endif
                        @if ($order->status == \App\Enums\OrderStatusEnum::PROCESSING)
                            <span class="badge badge-primary">Sedang di Proses</span>
                        @endif
                        @if ($order->status == \App\Enums\OrderStatusEnum::CANCELED)
                            <span class="badge badge-danger">Dibatalkan</span>
                        @endif
                        @if ($order->status == \App\Enums\OrderStatusEnum::COMPLETED)
                            <span class="badge badge-success">Selesai</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->onEachSide(5)->links() }}
</div>
