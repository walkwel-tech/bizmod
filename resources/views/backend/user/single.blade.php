@extends('layouts.admin', ['title' => __('User Profile')])

@section('content')
<x-page-header :title="$user->name" class="col-lg-7"
    description="This is the profile page. You can see the progress you've made with your work and manage your projects or assigned tasks"
    :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <!-- <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <x-user.insight :user="$user"></x-user.insight>
        </div> -->
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-12 mb-0">
                            <h3 class="col-12 mb-0">{{ ($form['action'] == 'create') ? 'New' : 'Edit'  }} User</h3>
                        </div>
                        @if (isset($backURL))
                        <div class="col-12 col-md-12 mt-4">
                            <a class="btn btn-success" href="{{ $backURL }}" >Go Back</a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ $form['action_route'] }}" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        @method($form['method'])
                        @if ($user->getKey())
                            <input type="hidden" name="id" value="{{ $user->getKey() }}">
                        @endif

                        <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>

                        @if (session('status'))
                        <x-alert type="success">
                            {{ session('status') }}
                        </x-alert>
                        @endif

                        @if($errors->any())
                            {{ implode('', $errors->all('<div>:message</div>')) }}
                        @endif

                        <div class="pl-lg-4">
                            <x-form.input-file :lable="$user->avatar"/>

                            <x-form.input name="first_name" :title="__('First Name')" :value="$user->first_name" required />
                            <x-form.input name="middle_name" :title="__('Middle Name')" :value="$user->middle_name" />
                            <x-form.input name="last_name" :title="__('Last Name')" :value="$user->last_name" required />

                            <x-form.input name="email" :title="__('Email')" :value="$user->email" type="email" placeholder="someone@example.com" required :hideLabel="true">
                                <x-form.toggle class="mb-2" name="email_verified" title="Email" :value="$user->hasVerifiedEmail()" />
                            </x-form.input>

                            @if ( !method_exists(auth()->user(), 'hasRole') || auth()->user()->hasRole('super'))
                            <x-roles-selector :model="$user"/>
                            @endif

                            @if($form['passwords'])
                                <x-form.input type="password" name="password" :title="__('New Password')" value=""/>
                                <x-form.input type="password" name="password_confirmation" :title="__('Confirm Password')" value="" />
                            @endif

                            <x-form.input name="country" :title="__('Country')" :value="$user->country"  />
                                <x-form.input name="state" :title="__('State')" :value="$user->state"  />
                                <x-form.input name="city" :title="__('City')" :value="$user->city"  />
                                <x-form.input name="zip" :title="__('Zip')" :value="$user->zip"  />
                                <x-form.input type="number" name="phone" :title="__('Phone')" :value="$user->phone"  required/>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                    @if(!$form['passwords'])
                    <hr class="my-4" />
                    <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
                        @csrf
                        @method('put')

                        <h6 class="heading-small text-muted mb-4">{{ __('Password') }}</h6>

                        @if (session('password_status'))
                        <x-alert type="success">
                            {{ session('password_status') }}
                        </x-alert>
                        @endif

                        <div class="pl-lg-4">
                            <x-form.input type="password" name="old_password" :title="__('Current Password')" value="" required />
                            <x-form.input type="password" name="password" :title="__('New Password')" value="" required />
                            <x-form.input type="password" name="password_confirmation" :title="__('Confirm Password')" value="" required />

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Change password') }}</button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
            <!-- <div class="card my-4 py-4">
                <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-10 mb-0">
                                <h3>Token</h3>
                            </div>
                            <div class="col-12 col-md-2 text-right">

                            </div>
                        </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @livewire('backend.user-tokens', ['user' => $user])
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection

@push('js')
<script>
    var statesSelected = @json($user->addresses->pluck('state_id', 'slug')->toArray());
    var citiesSelected = @json($user->addresses->pluck('city_id', 'slug')->toArray());
</script>
@endpush
