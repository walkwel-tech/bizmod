@extends('layouts.admin', ['title' => __('Export')])


@section('content')
<x-page-header title="Export" class="col-lg-7" :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">

            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-12 mb-0">
                            <h3>{{ ($form['action'] == 'create') ? 'New' : 'Edit'  }} Export</h3>
                        </div>
                        @if (isset($backURL))
                        <div class="col-12 col-md-12 mt-4">
                            <a class="btn btn-success" href="{{ $backURL }}">Go Back</a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="{{ $form['action_route'] }}" enctype="multipart/form-data">
                                @csrf
                                @method($form['method'])

                                <h6 class="heading-small text-muted mb-4">{{ __('Export information') }}</h6>

                                @if (session('status'))
                                <x-alert type="success">
                                    {{ session('status') }}
                                </x-alert>
                                @endif

                                <div class="pl-lg-4">
                                    <div class="form-group">
                                    <label class="form-control-label" for="input-export_type">Select Export type</label>
                                    <x-form.radio name="export_type" title="User" value="user" checked="user" />
                                    <x-form.radio name="export_type" title="Business" value="business" checked="" />
                                    <x-form.radio name="export_type" title="Client" value="client" checked="" />
                                    <x-form.radio name="export_type" title="Codes" value="code" checked=""/>

                                    </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success mt-4">{{ __('Export') }}</button>
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