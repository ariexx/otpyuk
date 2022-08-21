<tr>
    <td>{{ $history->present_sms_message }}</td>
    <td>{{ $history->phone_number }}</td>
    <td>
        @if ($history->status == \App\Enums\OrderStatusEnum::PENDING ||
            $history->status == \App\Enums\OrderStatusEnum::PROCESSING ||
            $history->status == \App\Enums\OrderStatusEnum::REPEAT)
            <x-countdown :expires="$history->expires_at">
                @if ($history->expires_at->isPast())
                    -
                @else
                    <span x-text="timer.minutes">{{ $component->minutes() }}</span> Menit
                @endif
            </x-countdown>
        @elseif($history->status == \App\Enums\OrderStatusEnum::CANCELED)
            Canceled
        @else
            Completed
        @endif
    </td>
    <td class="col text-center">
        @if ($history->status === \App\Enums\OrderStatusEnum::PENDING)
            @if ($history->expires_at->isPast())
                @php
                    $history->status = \App\Enums\OrderStatusEnum::CANCELED;
                    \App\Models\User::findOrFail(auth()->user()->id)->update([
                        'balance' => \App\Models\User::findOrFail(auth()->user()->id)->balance + \App\Models\Order::findOrFail($history->id)->service->price,
                    ]);
                    $history->save();
                @endphp
            @else
                <button wire:click="cancel({{ $history->id }})" class="btn btn-danger">
                    Cancel
                </button>
            @endif
        @elseif ($history->status === \App\Enums\OrderStatusEnum::PROCESSING && !empty($history->sms_message))
            @if ($history->expires_at->isPast())
                @php
                    $history->status = \App\Enums\OrderStatusEnum::COMPLETED;
                    $history->save();
                @endphp
            @else
                <button wire:click="done({{ $history->id }})" class="btn btn-success">Done</button>
                <button wire:click="repeat({{ $history->id }})" class="btn btn-info">Repeat</button>
            @endif
        @elseif($history->status === \App\Enums\OrderStatusEnum::REPEAT)
            @if ($history->expires_at->isPast())
                @php
                    $history->status = \App\Enums\OrderStatusEnum::COMPLETED;
                    $history->save();
                @endphp
            @else
                <button wire:click="done({{ $history->id }})" class="btn btn-success">Done</button>
            @endif
        @endif
    </td>
</tr>
