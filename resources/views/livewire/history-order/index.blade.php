<div wire:poll.10s>
    <table class="table table-striped" id="table-1">
        <thead>
            <tr>
                <th>SMS Message</th>
                <th>Nomor</th>
                <th>Expired</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $history)
                @if (empty($history) || $history->status === \App\Enums\OrderStatusEnum::COMPLETED || $history->status === \App\Enums\OrderStatusEnum::CANCELED)
                @else
                    <livewire:history-order.show :history="$history" :key="$history->id . uniqid()" />
                @endif
            @endforeach
        </tbody>
    </table>
    @if (empty($history) || $history->status === \App\Enums\OrderStatusEnum::COMPLETED || $history->status === \App\Enums\OrderStatusEnum::CANCELED || empty($data))
    @else
        {{ $data->links() }}
    @endif
</div>
