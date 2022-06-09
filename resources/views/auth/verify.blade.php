@extends('layouts.app')

@section('content')
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-12">
            <div class="col-12 mb-4">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif
                <div class="hero text-white hero-bg-image"
                    style="background-image: url('{{ asset('img/unsplash/eberhard-grossgasteiger-1207565-unsplash.jpg') }}');">
                    <div class="hero-inner">
                        <h2>Welcome, Hero!</h2>
                        <p class="lead">
                            {{ __('Sebelum diproses, silahkan click link verifikasi yang ada di email.') }}
                            {{ __('Jika tidak menerima email.') }},</p>
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <div class="mt-4">
                                <button type="submit" class="btn btn-outline-primary btn-lg btn-icon icon-left"><i
                                        class="far fa-envelope"></i>
                                    Click here to request another.</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
