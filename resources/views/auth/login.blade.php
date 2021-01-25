@extends('layouts.app', ['class' => 'auth-page'])

@section('content')
<!-- Main -->
<div class="d-md-flex h-md-100 align-items-center auth_panel">
    <div class="col-lg-6 col-md-12 auth_panel_form">
        <div class="d-flex align-items-center justify-content-center h-100 flex-column">
            <div class="login_form">
                <div class="card-header bg-transparent pb-5">
                    <div class="text-muted text-center mt-2 mb-4"><small>{{ __('Log in with') }}</small></div>
                    <div class="text-center">
                        <x-ui.button-icon title="Facebook" :icon="asset('argon/img/icons/common/facebook.svg')" text="" href="{{ route('login.social', ['provider' => 'facebook']) }}" />
                        <x-ui.button-icon title="Google" :icon="asset('argon/img/icons/common/google.svg')" text="" href="{{ route('login.social', ['provider' => 'google']) }}" />
                        <x-ui.button-icon title="Twitter" :icon="asset('argon/img/icons/common/twitter.svg')" text="" href="{{ route('login.social', ['provider' => 'twitter']) }}" />
                        @if($noPass)
                            <x-ui.button-icon title="Password" :icon="asset('argon/img/icons/common/lock.svg')" text="" href="{{ route('login') }}" />
                        @else
                            <x-ui.button-icon title="OTP" :icon="asset('argon/img/icons/common/otp.svg')" text="" href="{{ route('login.social', ['provider' => 'otp']) }}" />
                        @endif
                    </div>
                </div>
                <div class="card-body px-lg-5 py-lg-5">
                    <div class="text-center text-muted mb-4">
                        <small>{{ $message }}</small>
                    </div>
                    <form role="form" method="POST" action="{{ $loginRoute }}">
                        @csrf
                        <div class="user_input">
                            <x-form.input name="email" :placeholder="__('test@example.com')" icon="user_icon" title="Email address" type="email" :value="$email ?? ''" />
                        </div>

                        @if (!$noPass)
                        <div class="pwd_input">
                            <x-form.input name="password" :placeholder="__('Password')"  icon="pwd_icon" title="Password" type="password" />
                        </div>
                        @endif
                        <div class="text-center">
                            <button type="submit" class="button button-auth">{{ $actionText }}</button>
                        </div>
                    </form>
                    <div class="d-flex">
                        <div class="col-12">
                            @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bottom-link text-center">
                                {{ __('Register?') }}
                            </a>
                            @endif
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="bottom-link text-center">
                                {{ __('Forgot password?') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12 auth_panel_splash">
    </div>
</div>


<!-- End Main -->

@endsection
