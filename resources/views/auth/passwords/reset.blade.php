@extends('layouts.admin', ['class' => 'bg-default'])

@section('content')
    @include('layouts.headers.guest')

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>{{ __('Reset Password') }}</small>
                        </div>
                        <form role="form" method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <x-form.input-alternative name="email" :placeholder="__('Email')" icon="ni ni-email-83" type="email" />
                            <x-form.input-alternative name="password" :placeholder="__('Password')" icon="ni ni-lock-circle-open" type="password" />
                            <x-form.input-alternative name="password_confirmation" :placeholder="__('Confirm Password')" icon="ni ni-lock-circle-open" type="password" />

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('Reset Password') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
