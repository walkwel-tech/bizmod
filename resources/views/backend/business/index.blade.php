@extends('layouts.admin')

@section('content')
<x-page-header title="Business" class="col-lg-7"
    :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-12 ">
                            <form method="get" accept-charset="utf-8" class="row">
                                <div class="col-10">
                                    <div class="row">
                                        @foreach ($allowedFilters as $filter)
                                        <div class="col-4">
                                            <x-form.input :name="'filter['. $filter . ']'" :title="__($filter)" hideLabel="true" :value="Arr::get($searchedParams, $filter)"/>

                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="button-group">
                                        <button type="submit" class="btn btn-info">{{ __('Search') }}</button>
                                        <a href="{{ URL::current() }}" class="btn btn-danger">{{ __('Reset') }}</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-8">
                            <h3 class="mb-0">Business</h3>
                        </div>
                        @if($addNew)
                        <div class="col-4 text-right">
                            <a href="{{ route('admin.business.create') }}" class="btn btn-sm btn-primary">Add Business</a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Prefix</th>
                                <th scope="col">Owner</th>
                                <th scope="col">Codes</th>
                                <th scope="col">Claimed Code</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($businesses as $business)
                            <tr>
                                <td>{{ $business->getOriginalSEOTitle() }}</td>
                                <td>{{ $business->prefix }}</td>
                                <td>{{ $business->getOwnerTitle() }}</td>
                                <td>
                                    <a href="{{ route('admin.code.index', ['filter' => ['business.title' => $business->title]]) }}">{{ $business->codes_count }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.code.index', ['filter' => ['business.title' => $business->title, 'claimed' => true]]) }}">{{ $business->claimed_codes_count }}</a>
                                </td>
                                <td class="d-flex justify-content-end">
                                    @can('backend.businesses.update')
                                    <a class="btn btn-info btn-icon btn-icon-md rounded-0" href="{{ route('admin.business.show', $business) }}" data-toggle="tooltip" data-placement="left" title="{{ __('basic.actions.view', ['name' => 'Business']) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @endcan
                                    @can('backend.businesses.delete')
                                    <x-ui.button-delete :model="$business" :route-destroy="route('admin.business.destroy', $business)" :route-delete="route('admin.business.delete', $business)" :route-restore="route('admin.business.restore', $business)" model-name="Business" :identifier="$business->id"/>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $businesses->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
