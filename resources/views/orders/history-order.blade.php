@extends('layouts.app')

@section('content')
    <div class="section-header">
        <h1>{{ __('History Orders') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">{{ __('History Orders') }}</a></div>
        </div>
    </div>

    <div class="section-body">
        {{-- <h2 class="section-title">History Order</h2> --}}
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <livewire:history-order.user />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
