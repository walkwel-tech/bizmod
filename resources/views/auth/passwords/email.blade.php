@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <div class="d-md-flex h-md-100 align-items-center auth_panel">
            <div class="col-lg-6 col-md-12 auth_panel_form">
                <div class="d-flex align-items-center justify-content-center h-100 flex-column">
                    <div class="login_form">
                        <h2 class="mb-2">Reset your <strong>Password?</strong></h2>
                        <p class="mb-4">Don't worry. Resetting your password is easy. Just tell us the email address you registered wit BidForm.</p>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form role="form" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="user_input">            
                              <x-form.input name="email" :placeholder="__('eg. test@gmail.com')" icon="user_icon" title="email address" type="email" />
                            </div>  
                            <div class="text-center">
                                <button type="submit" class="button button-auth">{{ __('Send') }}</button>
                            </div>
                        </form>
                        <div class="d-flex">
                            <div class="col-12">
                                @if (Route::has('password.request'))
                                <a href="{{ route('login') }}" class="bottom-link text-center">
                                    Back to Login
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 auth_panel_splash">
            </div>
   </div>
@endsection
