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
                                    @if($code->getKey())
                                        <x-form.select name="business_id" :title="__('Business')" :selected="$code->business_id"
                                            :options="$businessOptions" disabled="disabled"  :hide-label="true">
                                            @if ($code->business)
                                            <a href="{{ route('admin.business.show', $code->business) }}"
                                                class="btn btn-link px-0 text-left">
                                                <i class="fas fa-level-up-alt"></i> {{ __('Business') }}
                                            </a>
                                            @endif
                                        </x-form.select>

                                        <x-form.input name="batch_no" :title="__('Batch')" :value="$code->batch_no" readonly />

                                        <x-form.input name="code" :title="__('Code')" :value="$code->code" readonly />

                                        <x-form.input type="number" name="page_id" :title="__('Page ID')" :value="$code->claim_details['page_id']" readonly />
                                        <x-form.input  name="location" :title="__('Location')" :value="$code->claim_details['location']" readonly />
                                        <x-form.input  name="country" :title="__('Country')" :value="$code->claim_details['country']"  readonly/>
                                        <x-form.input  name="zip" :title="__('Zip')" :value="$code->claim_details['zip']"  readonly/>
                                        <x-form.input  name="zip" :title="__('Claimed on')" :value="$code->claimed_on"  readonly/>
                                        <x-form.textarea  name="description" :title="__('Add Note')" :value="$code->description" />
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                        </div>
                                    @else
                                        <x-form.select name="business_id" :title="__('Business')" :selected="$code->business_id"
                                            :options="$businessOptions" required :hide-label="true">
                                            @if ($code->business)
                                            <a href="{{ route('admin.business.show', $code->business) }}"
                                                class="btn btn-link px-0 text-left">
                                                <i class="fas fa-level-up-alt"></i> {{ __('Business') }}
                                            </a>
                                            @endif
                                        </x-form.select>

                                        <x-form.input name="batch_no" :title="__('Batch')" :value="$code->batch_no" required />

                                        <x-form.input name="prefix" :title="__('Code Prefix')" :value="$code->code" required />
                                        <x-form.input type="number" name="no_of_codes" :title="__('Generate No. of code')" value="" required />

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                        </div>

                                    @endif


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

    const businessData = @json($businessOptions->mapWithKeys(function($c) {return [$c->getKey() => $c->only(['prefix', 'next_batch'])];}));


    $(function () {
        const businessSelector = $('[name="business_id"]');

        const {next_batch, prefix} = businessData[businessSelector.val()]
        @if(!$code->getKey())
            $('[name="batch_no"]').val(next_batch);
            $('[name="prefix"]').val(prefix);
        @endif

        businessSelector.change(function (event) {
            const {next_batch, prefix} = businessData[$(this).val()];

            $('[name="batch_no"]').val(next_batch);
            $('[name="prefix"]').val(prefix);
        });
    });
</script>
@endpush
