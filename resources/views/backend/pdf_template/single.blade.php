@extends('layouts.admin', ['title' => __('Business')])


@section('content')
<x-page-header title="Pdf Template" class="col-lg-7" :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-10 mb-0">
                            <h3>{{ ($form['action'] == 'create') ? 'New' : 'Edit'  }} Template</h3>
                        </div>
                        <div class="col-12 col-md-2 text-right">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="{{ $form['action_route'] }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method($form['method'])
                                @if ($pdf_template->getKey())
                                <input type="hidden" name="id" value="{{ $pdf_template->getKey() }}">
                                @endif

                                <h6 class="heading-small text-muted mb-4">{{ __('Template information') }}</h6>

                                @if (session('status'))
                                <x-alert type="success">
                                    {{ session('status') }}
                                </x-alert>
                                @endif

                                <div class="pl-lg-4">
                                    <x-form.input name="title" :title="__('Title')" :value="$pdf_template->title"
                                        required />


                                    <x-form.textarea name="description" placeholder="Descr"
                                        :value="$pdf_template->description">
                                        {{ __('basic.inputs.address.details') }}
                                        </x-form.input>

                                        <x-form.input-file name="path" :label="$pdf_template->path" :title="__('Sample pdf')"/>

                                        <x-form.input type="number" name="business[position][x]" :title="__('Business X position')" :value="$pdf_template->configuration->getBusinessPositionX()" required />
                                        <x-form.input type="number" name="business[position][y]" :title="__('Business Y position')" :value="$pdf_template->configuration->getBusinessPositionY()" required />

                                        <x-form.input type="text" name="code[text][color]" :title="__('Code Text Color')" :value="$pdf_template->configuration->getCodeTextColor()" required />
                                        <x-form.input type="number" name="code[position][x]" :title="__('Code X position')" :value="$pdf_template->configuration->getCodePositionX()" required />
                                        <x-form.input type="number" name="code[position][y]" :title="__('Code Y position')" :value="$pdf_template->configuration->getCodePositionY()" required />

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
