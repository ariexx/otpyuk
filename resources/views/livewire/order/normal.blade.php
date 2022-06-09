<div>
    <form wire:submit.prevent='normalOrder'>

        @csrf
        {{-- Todo : Cek jika di services ada promo masukkan ke tab promo --}}
        @error('serviceId')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @error('operatorId')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <livewire:services.index wire:model='serviceId' />
        <livewire:operator.index wire:model='operatorId' />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>
                Order</button>
        </div>
    </form>
</div>
