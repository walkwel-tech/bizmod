@extends('layouts.admin', ['title' => __('Page')])

@section('content')
<x-page-header title="Page" class="col-lg-7"
    :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-10 mb-0">
                            <h3>{{ ($form['action'] == 'create') ? 'New' : 'Edit'  }} Page</h3>
                        </div>
                        <div class="col-12 col-md-2 text-right">
                            <a class="btn btn-sm btn-primary" href="{{ route('admin.page.view', $page) }}" data-toggle="tooltip" data-placement="left" title="{{ __('basic.actions.view', ['name' => 'Page']) }}">
                                Preview
                            </a>
                        </div>
                        <div class="col-12 col-md-12 mt-4">
                            <a class="btn btn-success" href="{{ route('admin.page.index') }}" >Go Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="{{ $form['action_route'] }}" autocomplete="off">
                                @csrf
                                @method($form['method'])
                                @if ($page->getKey())
                                    <input type="hidden" name="id" value="{{ $page->getKey() }}">
                                @endif

                                <h6 class="heading-small text-muted mb-4">{{ __('Page information') }}</h6>

                                @if (session('status'))
                                <x-alert type="success">
                                    {{ session('status') }}
                                </x-alert>
                                @endif

                                <div class="pl-lg-4">
                                    <x-form.input name="title" :title="__('Title')" :value="$page->title" required />


                                    <x-form.textarea name="content" placeholder="Content" :value="$page->content">
                                        {{ __('basic.inputs.address.details') }}
                                    </x-form.input>
                                    <span> Use variable : {% user_avatar %} , {% user_name %}</span>


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
