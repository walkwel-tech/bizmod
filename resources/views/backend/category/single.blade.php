@extends('layouts.admin', ['title' => __('Category')])

@section('content')
<x-page-header title="Category" class="col-lg-7"
    :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-10 mb-0">
                            <h3>{{ ($form['action'] == 'create') ? 'New' : 'Edit'  }} Category</h3>
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
                                @if ($category->getKey())
                                    <input type="hidden" name="id" value="{{ $category->getKey() }}">
                                @endif

                                <h6 class="heading-small text-muted mb-4">{{ __('Category information') }}</h6>

                                @if (session('status'))
                                <x-alert type="success">
                                    {{ session('status') }}
                                </x-alert>
                                @endif

                                <div class="pl-lg-4">
                                    <x-form.input name="title" :title="__('Title')" :value="$category->title" required />


                                    <x-form.textarea name="description" placeholder="Descr" :value="$category->description">
                                        {{ __('basic.inputs.address.details') }}
                                    </x-form.input>
                                    

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

