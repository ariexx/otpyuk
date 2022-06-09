<div>
    @if (session()->has('message'))
        <div class="alert alert-success">

            {{ session('message') }}

        </div>
    @elseif (session()->has('error'))
        <div class="alert alert-danger">

            {{ session('error') }}

        </div>
    @endif
    <form wire:submit.prevent='instantOrder'>
        @csrf
        {{-- Todo : Cek jika di services ada promo masukkan ke tab promo --}}
        @error('serviceId')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <livewire:services.index wire:model='serviceId' />
        <div class="col text-center">
            <button class="btn btn-primary"><i class="fa fa-shopping-cart"></i>
                Order</button>
        </div>
    </form>
</div>
