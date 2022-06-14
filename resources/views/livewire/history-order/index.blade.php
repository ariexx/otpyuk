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
            @forelse ($data as $history)
                <livewire:history-order.show :history="$history" :key="$history->id . uniqid()" />
            @empty
                <tr>
                    <td colspan="4" class="text-center">
                        <h5>Tidak ada data</h5>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if (empty($history) || $history->status === \App\Enums\OrderStatusEnum::COMPLETED || $history->status === \App\Enums\OrderStatusEnum::CANCELED || empty($data))
    @else
        {{ $data->links() }}
    @endif
</div>
