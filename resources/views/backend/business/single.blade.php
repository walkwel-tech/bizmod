@extends('layouts.admin', ['title' => __('Business')])


@section('content')
<x-page-header title="Business" class="col-lg-7" :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">

            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-10 mb-0">
                            <h3>{{ ($form['action'] == 'create') ? 'New' : 'Edit'  }} Business</h3>
                        </div>
                        <div class="col-12 col-md-2 text-right">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="{{ $form['action_route'] }}" autocomplete="off">
                                @csrf
                                @method($form['method'])
                                @if ($business->getKey())
                                <input type="hidden" name="id" value="{{ $business->getKey() }}">
                                @endif

                                <h6 class="heading-small text-muted mb-4">{{ __('Business information') }}</h6>

                                @if (session('status'))
                                <x-alert type="success">
                                    {{ session('status') }}
                                </x-alert>
                                @endif

                                <div class="pl-lg-4">
                                    <x-form.input name="title" :title="__('Title')" :value="$business->title"
                                        required />


                                    <x-form.textarea name="description" placeholder="Descr"
                                        :value="$business->description">
                                        {{ __('basic.inputs.address.details') }}
                                        </x-form.input>

                                        <x-form.input name="prefix" :title="__('Prefix')" :value="$business->prefix"
                                            required />

                                        <x-form.input type="number" name="threshold" :title="__('Threshold Per Client')"
                                            :value="$business->threshold" required />

                                        <x-form.input name="webhook_url" :title="__('Webhook URL')"
                                            :value="$business->webhook_url" required />

                                        @if($business->getKey())
                                        <x-form.select name="owner_id" :title="__('User')"
                                            :selected="$business->owner_id" :options="$users" required
                                            :hide-label="true">
                                            <a href="{{ route('admin.user.show', $business->owner) }}"
                                                class="btn btn-link px-0 text-left">
                                                <i class="fas fa-level-up-alt"></i> {{ __('Owner') }}
                                            </a>
                                        </x-form.select>
                                        @else
                                        <x-form.select name="owner_id" :title="__('User')"
                                            :selected="$business->owner_id" :options="$users" required />
                                        @endif

                                        <x-form.input name="first_name" :title="__('First Name')" value="" readonly />
                                        <x-form.input name="last_name" :title="__('Last Name')" value="" readonly />
                                        <x-form.input name="email" :title="__('Email')" value="" readonly />
                                        <x-form.input name="phone" :title="__('Phone')" value="" readonly />


                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                        </div>


                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card my-4">
                <div class="card-header bg-white border-0">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-10 mb-0">
                                <h3>Business Users</h3>
                            </div>
                            <div class="col-12 col-md-2 text-right">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @livewire('backend.business-users', ['business' => $business])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @include('layouts.footers.auth')
</div>
@endsection

@push('js')
<script>
    const userData = @json($usersData);

    $(function () {
        const userSelector = $('[name="owner_id"]');

        userSelector.change(function (event) {
            const {
                first_name,
                last_name,
                email,
                phone
            } = userData[$(this).val()];
            $('[name="first_name"]').val(first_name);
            $('[name="last_name"]').val(last_name);
            $('[name="email"]').val(email);
            $('[name="phone"]').val(phone);
        });

        userSelector.trigger('change');
    });

</script>
@endpush
