@extends('layouts.admin', ['title' => __('Code')])

@section('content')
<x-page-header title="Code" class="col-lg-7" :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">

        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">

                        <div class="col-12 col-md-12 mb-0">
                            <h3>{{ ($form['action'] == 'create') ? 'New' : 'Edit'  }} Code</h3>
                        </div>

                        <div class="col-12 col-md-12 mt-4">
                            <a class="btn btn-success" href="{{ $backURL }}" >Go Back</a>
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
                                            :options="$businessOptions" disabled="disabled"  :hide-label="false">
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
                                        <x-form.input  name="claimed_on" :title="__('Claimed on')" :value="$code->claimed_on"  readonly/>
                                            @if ($code->digital_template)
                                            <a href="{{ route('admin.template.show', $code->digital_template) }}"
                                                class="btn btn-link px-0 text-left">
                                                <i class="fas fa-level-up-alt"></i> {{ __('Pdf Template') }}
                                            </a>
                                            @endif
                                        <x-form.input  name="digital_template_id" :title="__('Digital Pdf Template')" :value="$code->digital_template ? $code->digital_template->path : null"  readonly/>
                                            @if ($code->print_ready_template)
                                            <a href="{{ route('admin.template.show', $code->print_ready_template) }}"
                                                class="btn btn-link px-0 text-left">
                                                <i class="fas fa-level-up-alt"></i> {{ __('Pdf Template') }}
                                            </a>
                                            @endif
                                            <x-form.input  name="print_ready_template_id" :title="__('Print Ready Pdf Template')" :value="$code->print_ready_template->path"  readonly/>
                                            <x-form.input  name="given_on" :title="__('Given on')" :value="$code->given_on"  readonly/>
                                        <x-form.textarea  name="description" :title="__('Add Note')" :value="$code->description" />
                                        <div class="text-center">
                                            @if (!$code->given_on)
                                            <button id="code_given_btn" type="button" class="btn btn-success mt-4">{{ __('Given') }}</button>
                                            @endif
                                            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                        </div>
                                    @else
                                        <x-form.select name="business_id" :title="__('Business')" :selected="$code->business_id"
                                            :options="$businessOptions" required :hide-label="false">
                                            @if ($code->business)
                                            <a href="{{ route('admin.business.show', $code->business) }}"
                                                class="btn btn-link px-0 text-left">
                                                <i class="fas fa-level-up-alt"></i> {{ __('Business') }}
                                            </a>
                                            @endif
                                        </x-form.select>

                                        <x-form.input name="batch_no" :title="__('Batch')" :value="$code->batch_no" required />

                                        <x-form.input name="prefix" :title="__('Code Prefix')" :value="$code->code" required readonly />
                                        <x-form.input type="number" name="no_of_codes" :title="__('Generate No. of code')" value="" required />

                                        <x-form.select name="digital_template_id" :title="__('Digital Pdf Template')" :selected="$code->digital_template_id"
                                            :options="$digitalPdfTemplates" required :hide-label="false">
                                            @if ($code->digital_template)
                                            <a href="{{ route('admin.business.show', $code->digital_template) }}"
                                                class="btn btn-link px-0 text-left">
                                                <i class="fas fa-level-up-alt"></i> {{ __('Pdf Template') }}
                                            </a>
                                            @endif
                                        </x-form.select>

                                        <x-form.select name="print_ready_template_id" :title="__('Print Ready Pdf Template')" :selected="$code->print_ready_template_id"
                                            :options="$printPdfTemplates" required :hide-label="false">
                                            @if ($code->print_ready_template)
                                            <a href="{{ route('admin.business.show', $code->print_ready_template) }}"
                                                class="btn btn-link px-0 text-left">
                                                <i class="fas fa-level-up-alt"></i> {{ __('Pdf Template') }}
                                            </a>
                                            @endif
                                        </x-form.select>

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

    const businessData = @json($businessOptions->mapWithKeys(function($c) {return [$c->getKey() => $c->only(['prefix', 'next_batch' ])];}));
    const digitalPdfData = @json($digitalPdfTemplates->groupBy('business_id'));
    const printPdfData = @json($printPdfTemplates->groupBy('business_id'));

    $(function () {
        const businessSelector = $('[name="business_id"]');
        const digitalPdfSelector = $('[name="digital_template_id"]');
        const printPdfSelector = $('[name="print_ready_template_id"]');

        const {next_batch, prefix} = businessData[businessSelector.val()];

        @if(!$code->getKey())
            $('[name="batch_no"]').val(next_batch);
            $('[name="prefix"]').val(prefix);
        @endif

        businessSelector.change(function (event) {
            const {next_batch, prefix} = businessData[$(this).val()];
            @if(!$code->getKey())
            $('[name="batch_no"]').val(next_batch);
            @endif


            $('[name="prefix"]').val(prefix);
            @if(!$code->getKey())
            digitalPdfSelector.empty();
            digitalPdfData[businessSelector.val()].forEach(template => {
                digitalPdfSelector.append(new Option(template.text, template.id, false, false));
            });
            printPdfSelector.empty();
            printPdfData[businessSelector.val()].forEach(template => {
                printPdfSelector.append(new Option(template.text, template.id, false, false));
            });
            @endif
        });

        businessSelector.trigger('change');

        $('#code_given_btn').click(function (event) {
            var dt = new Date();
            //const = dt.getFullYear()+'-'+dt.getMonth()+'-'+dt.getDate()+' '+dt.getDate() ;
            const dateTime = @json(date("Y-m-d"));
            $('[name="given_on"]').val(dateTime);
        });
    });
</script>
@endpush
