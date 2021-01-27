@extends('layouts.admin', ['title' => __('Code')])

@section('content')
<x-page-header title="Code" class="col-lg-7" :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-10 mb-0">
                            <h3>{{ ($form['action'] == 'create') ? 'New' : 'Edit'  }} Code</h3>
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
                                @if ($code->getKey())
                                <input type="hidden" name="id" value="{{ $code->getKey() }}">
                                @endif

                                <h6 class="heading-small text-muted mb-4">{{ __('Code information') }}</h6>

                                @if (session('status'))
                                <x-alert type="success">
                                    {{ session('status') }}
                                </x-alert>
                                @endif

                                <div class="pl-lg-4">
                                    <x-form.input name="batch_no" :title="__('Batch No')" :value="$code->batch_no"
                                        required />

                                    <x-form.input name="code" :title="__('Code')" :value="$code->code" required />

                                    @if($code->getKey())
                                    <x-form.select name="business_id" :title="__('Business')" :selected="$code->business_id"
                                        :options="$business" required :hide-label="true">
                                        <a href="{{ route('admin.business.show', $code->business) }}"
                                            class="btn btn-link px-0 text-left">
                                            <i class="fas fa-level-up-alt"></i> {{ __('Business') }}
                                        </a>
                                    </x-form.select>
                                    @else
                                    <x-form.select name="business_id" :title="__('Business')" :selected="$code->business_id"
                                        :options="$business" required />
                                    @endif



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
