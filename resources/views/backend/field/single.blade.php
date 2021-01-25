@extends('layouts.admin', ['title' => __('Field')])

@section('content')
<x-page-header title="Fields" class="col-lg-7"
    :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-10 mb-0">
                            <h3>{{ ($form['action'] == 'create') ? 'New' : 'Edit'  }} Field</h3>
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
                                @if ($field->getKey())
                                    <input type="hidden" name="id" value="{{ $field->getKey() }}">
                                @endif

                                <h6 class="heading-small text-muted mb-4">{{ __('Field information') }}</h6>

                                @if (session('status'))
                                <x-alert type="success">
                                    {{ session('status') }}
                                </x-alert>
                                @endif

                                <div class="pl-lg-4">
                                    <div class="row col-12"><h4>Field</h4></div>
                                    @if($field->getKey())
                                    <x-form.select name="step_id" :title="__('Step')" :selected="$field->step_id" :options="$steps" required :hide-label="true">
                                        <a href="{{ route('admin.step.show', $field->step) }}" class="btn btn-link px-0 text-left">
                                            <i class="fas fa-level-up-alt"></i> {{ __('Step') }}
                                        </a>
                                    </x-form.select>
                                    @else
                                    <x-form.select name="step_id" :title="__('Step')" :selected="$field->step_id" :options="$steps" required />
                                    @endif

                                    <x-form.input name="title" :title="__('Title')" :value="$field->title" required />

                                    <x-form.input name="name" :title="__('Name')" :value="$field->name" required />

                                    <x-form.status-picker name="type" :title="__('Type')" :selected="$field->type" :options="$typeOptions" required />

                                    <x-form.input name="placeholder" :title="__('Placeholder')" :value="$field->placeholder" required />

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
