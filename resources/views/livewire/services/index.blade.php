<div class="form-group">
    <label>Services :</label>
    <select class="form-control" wire:model='servicesId'>
        @foreach ($data as $service)
            <livewire:services.show :service="$service" :key="$service->id" />
            {{-- Todo: Disini idenya mau nampilin list services ke services.show --}}
        @endforeach
    </select>
    <hr />
</div>
{{-- @php
                $discountPrice = ($services->discount_percentage / 100) * $services->price;
                $priceAfterDiscount = $services->price - $discountPrice;
            @endphp --}}
{{-- @if ($services->discount === 'iya')
                <option value="{{ $services->id }}" class="alert alert-success">
                    {{ $services->service_name }} - Rp.{{ $priceAfterDiscount }} (Diskon)
                </option>
            @endif --}}
