@extends('layouts.admin', ['title' => __('Notes')])

@section('content')
<x-page-header title="PDF" class="col-lg-7" :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">

        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-10 mb-0">
                            <h3>Pdf</h3>
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

                                <h6 class="heading-small text-muted mb-4">{{ __(' Select batch ') }}</h6>

                                @if (session('status'))
                                <x-alert type="success">
                                    {{ session('status') }}
                                </x-alert>
                                @endif

                                <div class="pl-lg-4">

                                    <x-form.select name="batch_no" :title="__('batches')" :options="$batches" required
                                        :hide-label="true">

                                    </x-form.select>

                                    <x-form.input name="pdf_template" :title="__('Pdf Template')" value="" readonly />


                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Generate') }}</button>
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
    $(function () {

        const batchSelector = $('[name="batch_no"]');

        batchSelector.change(function (event) {
            const attr = $(this).find("option:selected").attr('data-description');
            const pdf = JSON.parse(attr).title;
            $('[name="pdf_template"]').val(pdf);

        });

        batchSelector.trigger('change');

    });

</script>
@endpush
