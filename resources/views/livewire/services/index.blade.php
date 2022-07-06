<div class="form-group" wire:ignore.self>
    <label>Services :</label>
    <select class="form-control live-search" wire:model='servicesId'>
        @foreach ($data as $service)
            <option wire:key="item-{{ $service->id }}" value="{{ $service->id }}">
                {{ Str::ucfirst($service->service_name) }} -
                Rp.{{ $service->price }}
            </option>
            {{-- Todo: Disini idenya mau nampilin list services ke services.show --}}
        @endforeach
    </select>
    <hr />
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.live-search').select2({
                placeholder: 'Pilih Services',
                // allowClear: true,
            });
            $('.live-search').on('change', function(e) {
                Livewire.emit('servicesId', e.target.value);
            });
        });
    </script>
@endpush
