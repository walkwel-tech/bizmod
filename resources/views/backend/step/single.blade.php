@extends('layouts.admin', ['title' => __('Step')])

@section('content')
<x-page-header title="Step" class="col-lg-7"
    :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-10 mb-0">
                            <h3>{{ ($form['action'] == 'create') ? 'New' : 'Edit'  }} Step</h3>
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
                                @if ($step->getKey())
                                    <input type="hidden" name="id" value="{{ $step->getKey() }}">
                                @endif

                                <h6 class="heading-small text-muted mb-4">{{ __('Step information') }}</h6>

                                @if (session('status'))
                                <x-alert type="success">
                                    {{ session('status') }}
                                </x-alert>
                                @endif

                                <div class="pl-lg-4">
                                    <div class="row col-12"><h4>Step</h4></div>
                                    @if($step->getKey())
                                    <x-form.select name="service_id" :title="__('Service')" :selected="$step->service_id" :options="$services" required :hide-label="true">
                                        <a href="{{ route('admin.service.show', $step->service) }}" class="btn btn-link px-0 text-left">
                                            <i class="fas fa-level-up-alt"></i> {{ __('Service') }}
                                        </a>
                                    </x-form.select>
                                    @else
                                    <x-form.select name="service_id" :title="__('Service')" :selected="$step->service_id" :options="$services" required />
                                    @endif

                                    <x-form.input name="title" :title="__('Title')" :value="$step->title" required />

                                    <x-form.textarea name="description" placeholder="Descr" :value="$step->description">
                                        {{ __('basic.inputs.address.details') }}
                                    </x-form.input>

                                    <x-form.textarea name="content" placeholder="Content" :value="$step->content">
                                        {{ __('basic.inputs.address.details') }}
                                    </x-form.input>

                                    <x-form.input type="number" name="order" :title="__('Order')" :value="$step->order" required />


                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if($step->getKey())
                        @if($step->fields)
                            <div class="col-12 mt-4">
                                <div class="card shadow">
                                    <div class="card-header border-0">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h3 class="mb-0">Fields</h3>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Placeholder</th>
                                                    <th scope="col">Required</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($step->fields as $field)
                                                <tr>
                                                    <td>{{ $field->getSEOTitle() }}</td>
                                                    <td>{{ $field->name }}</td>
                                                    <td>{{ $field->type }}</td>
                                                    <td>{{ $field->placeholder }}</td>
                                                    <td>@if($field->required==1)Yes @else No @endif</td>
                                                    <td class="d-flex justify-content-end">
                                                        @can('backend.fields.update')
                                                        <a class="btn btn-info btn-icon btn-icon-md rounded-0" href="{{ route('admin.field.show', $field) }}" data-toggle="tooltip" data-placement="left" title="{{ __('basic.actions.view', ['name' => 'Field']) }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @endcan

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer py-4">
                                        <nav class="d-flex justify-content-end" aria-label="...">

                                        </nav>
                                    </div>
                                </div>
                            </div>

                        @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
