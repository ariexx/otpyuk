<div class="form-group">
    <label>Services :</label>
    <div wire:ignore>
        <select class="form-control live-search" wire:model='servicesId'>
            @if (Cache::has('services'))
                @foreach (Cache::get('services') as $service)
                    <option value="{{ $service->id }}">
                        {{ Str::ucfirst($service->service_name) }} -
                        Rp.{{ $service->price }}
                    </option>
                @endforeach
            @else
                @foreach ($data as $service)
                    <option value="{{ $service->id }}">{{ Str::ucfirst($service->service_name) }} -
                        Rp.{{ $service->price }}
                    </option>
                    {{-- Todo: Disini idenya mau nampilin list services ke services.show --}}
                @endforeach
            @endif

        </select>
    </div>
    <hr />
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.live-search').select2();
            $('.live-search').on('change', function(e) {
                let data = $('.live-search').select2("val");
                @this.set('servicesId', data);
            });
        });
    </script>
@endpush
