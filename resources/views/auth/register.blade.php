@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <div class="container mt--8 pb-5">
        <!-- Table -->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-transparent pb-5">
                        <div class="text-muted text-center mt-2 mb-4"><small>{{ __('Sign up with') }}</small></div>
                        <div class="text-center">
                        <x-ui.button-icon :icon="asset('argon/img/icons/common/facebook.svg')" text="" href="{{ route('login.social', ['provider' => 'facebook']) }}" />
                        <x-ui.button-icon :icon="asset('argon/img/icons/common/google.svg')" text="" href="{{ route('login.social', ['provider' => 'google']) }}" />
                        <x-ui.button-icon :icon="asset('argon/img/icons/common/twitter.svg')" text="" href="{{ route('login.social', ['provider' => 'twitter']) }}" />
                        </div>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>{{ __('Or sign up with credentials') }}</small>
                        </div>
                        <form role="form" method="POST" action="{{ route('register') }}">
                            @csrf

                            <x-form.input-alternative name="first_name" :placeholder="__('First Name')" icon="fas fa-chess-king" type="text" />
                            <x-form.input-alternative name="middle_name" :placeholder="__('Middle Name')" icon="fas fa-chess-rook" type="text" />
                            <x-form.input-alternative name="last_name" :placeholder="__('Last Name')" icon="fas fa-chess-knight" type="text" />
                            <x-form.input-alternative name="email" :placeholder="__('Email')" icon="ni ni-email-83" type="email" />
                            <x-form.input-alternative name="password" :placeholder="__('Password')" icon="ni ni-lock-circle-open" type="password" />
                            <x-form.input-alternative name="password_confirmation" :placeholder="__('Confirm Password')" icon="ni ni-lock-circle-open" type="password" />

                            <hr>
                            <x-form.input-alternative name="country" :placeholder="__('Country')" icon="fas fa-chess-king" type="text" />
                            <x-form.input-alternative name="state" :placeholder="__('State')" icon="fas fa-chess-king" type="text" />
                            <x-form.input-alternative name="city" :placeholder="__('City')" icon="fas fa-chess-king" type="text" />
                            <x-form.input-alternative name="zip" :placeholder="__('Zip')" icon="fas fa-chess-king" type="text" />
                            <x-form.input-alternative name="phone" :placeholder="__('Phone')" icon="fas fa-chess-king" type="text" />

                            {{--
                            <div class="text-muted font-italic">
                                <small>{{ __('password strength') }}: <span class="text-success font-weight-700">{{ __('strong') }}strong</span></small>
                            </div>
                            --}}
                            <div class="row my-4">
                                <div class="col-12">
                                    <x-form.checkbox name="tnc" :value="false">
                                        {{ __('I agree with the') }} <a href="#!">{{ __('Privacy Policy') }}</a>
                                    </x-form.checkbox>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-4">{{ __('Create account') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
<script>
    var fetchStatesURL = "{{ route('locations.states') }}";
    var fetchCitiesURL = "{{ route('locations.cities') }}";

    var statesSelected = [];
    var citiesSelected = [];
</script>
@endpush
