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
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">SMS Message</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $i++ }}</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
