@extends('layouts.admin', ['title' => __('Client')])

@section('content')
<x-page-header title="Client" class="col-lg-7" :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-10 mb-0">
                            <h3>{{ ($form['action'] == 'create') ? 'New' : 'Edit'  }} Client</h3>
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
                                @if ($client->getKey())
                                <input type="hidden" name="id" value="{{ $client->getKey() }}">
                                @endif

                                <h6 class="heading-small text-muted mb-4">{{ __('Client information') }}</h6>

                                @if (session('status'))
                                <x-alert type="success">
                                    {{ session('status') }}
                                </x-alert>
                                @endif

                                <div class="pl-lg-4">
                                    <x-form.input name="first_name" :title="__('First Name')"
                                        :value="$client->first_name" required />
                                    <x-form.input name="last_name" :title="__('Last Name')" :value="$client->last_name"
                                        required />

                                    <x-form.input name="email" :title="__('Email')" :value="$client->email" type="email"
                                        placeholder="someone@example.com" required >
                                    </x-form.input>

                                    <div class="form-group">
                                        <label class="">Country</label>

                                        <select name="country_name" class="form-control @error('country') is-invalid @enderror">
                                            @foreach($countries as $country)
                                            <option  data="{{ $country->phonecode }}" value="{{ $country->name }}" @if($client->relatesToCountry($country) || collect(old('country'))->contains($client->country)) selected @endif >
                                                {{ \Str::title($country->name) }}

                                            </option>
                                            @endforeach
                                        </select>

                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <x-form.input name="country_code" :title="__('Country Code')" :value="$client->country_code" readonly />
                                    <x-form.input name="phone" :title="__('Phone')" :value="$client->phone" required />
                                    <x-form.input name="zip" :title="__('Zip')" :value="$client->zip" required />

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    </div>

                                </div>
                            </form>
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

    const countryData = @json($countries->mapWithKeys(function($c) {return [$c->name => $c->only(['phonecode'])];}));

    $(function () {
        const countrySelector = $('[name="country_name"]');

        const {phonecode} = countryData[countrySelector.val()]
        $('[name="country_code"]').val(phonecode);

        countrySelector.change(function (event) {
            const {phonecode} = countryData[$(this).val()];

            $('[name="country_code"]').val(phonecode);

        });
    });
</script>
@endpush
