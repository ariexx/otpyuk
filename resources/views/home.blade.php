@extends('layouts.app')

@section('content')
    <div class="section-header">
        <h1>{{ __('Dashboard') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">{{ __('Dashboard') }}</a></div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Order</h2>
        <div class="row">
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="col text-center">
                            <div class="btn btn-outline-dark btn-icon icon-left mb-2">
                                <i class="fas fa-user"></i> Saldo : <span
                                    class="badge">{{ rupiah($balance) }}</span>
                            </div>
                        </div>
                        <ul class="nav nav-pills justify-content-center" id="myTab3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link border active mr-3" id="home-tab3" data-toggle="tab" href="#home3"
                                    role="tab" aria-controls="home" aria-selected="true">Instant Order</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link border" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab"
                                    aria-controls="profile" aria-selected="false">Normal</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent2">
                            <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                                <livewire:order.instant-order />
                            </div>
                            <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                                <livewire:order.normal />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Orders History</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <livewire:history-order.index>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
