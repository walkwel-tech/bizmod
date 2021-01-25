@extends('layouts.admin', ['title' => __('Role')])

@section('content')
<x-page-header title="Role" class="col-lg-7"
    :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="col-12 mb-0">{{ ($form['action'] == 'create') ? 'New' : 'Edit'  }} Role</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ $form['action_route'] }}" autocomplete="off">
                        @csrf
                        @method($form['method'])
                        @if ($role->getKey())
                            <input type="hidden" name="id" value="{{ $role->getKey() }}">
                        @endif

                        <h6 class="heading-small text-muted mb-4">{{ __('Role information') }}</h6>

                        @if (session('status'))
                        <x-alert type="success">
                            {{ session('status') }}
                        </x-alert>
                        @endif

                        <div class="pl-lg-4">
                            <x-form.input name="name" :title="__('Name')" :value="$role->name" required />
                            <x-permissions-selector :model="$role" />

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
