@extends('layouts.admin', ['title' => __('Service Order')])

@section('content')
<x-page-header title="Service Order" class="col-lg-7" :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-10 mb-0">
                            <h3>{{ ($form['action'] == 'create') ? 'New' : 'Edit'  }} Service Order</h3>
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
                                @if ($serviceorder->getKey())
                                <input type="hidden" name="id" value="{{ $serviceorder->getKey() }}">
                                @endif

                                <h6 class="heading-small text-muted mb-4">{{ __('Service Request') }}</h6>

                                @if (session('status'))
                                <x-alert type="success">
                                    {{ session('status') }}
                                </x-alert>
                                @endif

                                <div class="row">
                                    <div class="col-6">
                                        @if($serviceorder->getKey())
                                        <x-form.select name="service_id" :title="__('Service')" :selected="$serviceorder->service_id" :options="$services" required :hide-label="true">
                                            <a href="{{ route('admin.service.show', $serviceorder->service) }}"
                                                class="btn btn-link px-0 text-left">
                                                <i class="fas fa-level-up-alt"></i> {{ __('Service') }}
                                            </a>
                                        </x-form.select>
                                        @else
                                        <x-form.select name="service_id" :title="__('Service')" :selected="$serviceorder->service_id" :options="$services" required />
                                        @endif

                                        <x-form.input name="branch" :title="__('Branch')" :value="$serviceorder->branch" />

                                        <x-form.input name="datetime" :title="__('Booking Date & Time')" :value="$serviceorder->created_at??date('d-m-Y g:i:s a', time())" readonly disabled/>
                                    </div>

                                    <div class="col-6">
                                        @if($serviceorder->getKey())
                                        <x-form.select name="customer_id" :title="__('Customer')" :selected="$serviceorder->customer_id" :options="$users" required :hide-label="true">
                                            <a href="{{ route('admin.service.show', $serviceorder->user) }}" class="btn btn-link px-0 text-left">
                                                <i class="fas fa-level-up-alt"></i> {{ __('Users') }}
                                            </a>
                                        </x-form.select>
                                        @else
                                        <x-form.select name="customer_id" :title="__('Customer')" :selected="$serviceorder->customer_id" :options="$users" required />
                                        @endif
                                        <x-form.input name="phone_number" :title="__('Contact')" :value="$serviceorder->phone_number" required />

                                        <x-form.input name="amount" :title="__(' Price')" :value="$serviceorder->amount" required />
                                    </div>
                                </div>
                                <h6 class="heading-small text-muted mb-4">{{ __('Service time') }}</h6>
                                <div class="row">
                                    <x-form.date-range-picker name="serviceTime" title="Service Time" :value-start="$serviceorder->from_at" :value-end="$serviceorder->to_at" type="with-time" format="d-m-Y G:i K"/>
                                    <div class="col-6">
                                        <x-form.input name="address" :title="__(' Address')" :value="$serviceorder->address" required />
                                    </div>
                                    <div class="col-6">
                                        <x-form.input name="pin_code" :title="__(' Pin')" :value="$serviceorder->pin_code" required />
                                    </div>
                                    <div class="col-12">
                                        <x-form.textarea name="description" placeholder="Description" :value="$serviceorder->description">
                                            {{ __('basic.inputs.address.details') }}
                                        </x-form.input>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="heading-small text-muted mb-4">{{ __('Images') }}</h6>
                                        <x-form.input-file name="image[]" :title="__('Upload')" :lable="$serviceorder->image" multiple />
                                    </div>
                                </div>

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
