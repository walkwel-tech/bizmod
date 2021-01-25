@extends('layouts.admin', ['title' => __('Service')])

@section('content')
<x-page-header title="Service" class="col-lg-7"
    :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-10 mb-0">
                            <h3>{{ ($form['action'] == 'create') ? 'New' : 'Edit'  }} Service</h3>
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
                                @if ($service->getKey())
                                    <input type="hidden" name="id" value="{{ $service->getKey() }}">
                                @endif

                                <h6 class="heading-small text-muted mb-4">{{ __('Service information') }}</h6>

                                @if (session('status'))
                                <x-alert type="success">
                                    {{ session('status') }}
                                </x-alert>
                                @endif

                                <div class="pl-lg-4">
                                    <div class="row col-12"><h4>Category</h4></div>
                                    <div class="row col-12 form-group ">
                                        @foreach ($categories as $category)
                                        <div class="col-xs-12 col-md-3">
                                            <x-form.checkbox :name="'category['.$category->id.']'" :value="$service->hasCategory($category)" :title="__($category->title)" />
                                        </div>
                                        @endforeach
                                    </div>

                                    <x-form.input name="title" :title="__('Title')" :value="$service->title" required />

                                    <x-form.textarea name="description" placeholder="Descr" :value="$service->description">
                                        {{ __('basic.inputs.address.details') }}
                                    </x-form.input>

                                    <x-form.input type="text" name="amount" :title="__('Price')" :value="$service->amount" required />

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if($service->getKey())
                        @if($service->steps)
                        <div class="col-12 mt-4">
                            <div class="card shadow">
                                <div class="card-header border-0">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h3 class="mb-0">Steps</h3>
                                        </div>

                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Title</th>
                                                <th scope="col">Discription</th>
                                                <th scope="col">Content</th>
                                                <th scope="col">Order</th>
                                                <th scope="col">Submitable</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($service->steps as $step)
                                            <tr>
                                                <td>{{ $step->getSEOTitle() }}</td>
                                                <td>{{ $step->getSEODescription(2)  }}</td>
                                                <td>{{ $step->getSEOContent(2)  }}</td>
                                                <td>{{ $step->order  }}</td>
                                                <td>@if($step->submitable ==1) Yes @else No @endif</td>

                                                <td class="d-flex justify-content-end">
                                                    @can('backend.steps.update')
                                                    <a class="btn btn-info btn-icon btn-icon-md rounded-0" href="{{ route('admin.step.show', $step) }}" data-toggle="tooltip" data-placement="left" title="{{ __('basic.actions.view', ['name' => 'Step']) }}">
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
