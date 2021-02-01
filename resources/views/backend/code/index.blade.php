@extends('layouts.admin')

@section('content')
<x-page-header title="Codes" class="col-lg-7" :image-url="asset('argon/img/theme/profile-cover.jpg')" />

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
                                        <div class="col-3">
                                            <x-form.input :name="'filter['. $filter . ']'" :title="__($filter)"
                                                hideLabel="true" :value="Arr::get($searchedParams, $filter)" />

                                        </div>
                                        @endforeach

                                        <div class="col-6">
                                            <x-form.date-range-picker name="filter[claimed_between]" title="Claimed Date" nameStart="claimed_on_start" nameEnd="claimed_on_end"
                                                hideLabel="true" :valueStart="Arr::get($searchedParams, 'claimed_on_start')" :valueEnd="Arr::get($searchedParams, 'claimed_on_end')" startdateplaceholder="claim date start" enddateplaceholder="claim date end"/>
                                        </div>
                                        <div class="col-3">
                                            <x-form.checkbox name="filter[claimed]" title="Only claimed"
                                                :value="Arr::get($searchedParams, 'claimed')" />
                                        </div>

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
                        <div class="col-4">
                            <h3 class="mb-0">Codes</h3>
                        </div>




                        @if($addNew)
                        <div class="col-12 text-right">

                            <a href="{{ route('admin.code.create') }}" class="btn btn-sm btn-primary">Add Codes</a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Batch No</th>
                                <th scope="col">Code</th>
                                <th scope="col">Business</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Page</th>
                                <th scope="col">Location</th>
                                <th scope="col">Country</th>
                                <th scope="col">Zip</th>
                                <th scope="col">Claimed</th>
                                <th scope="col">Notes</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($codes as $code)
                            <tr>
                                <td>{{ $code->batch_no }}</td>
                                <td>{{ $code->code }}</td>
                                <td>{{ $code->business->getSEOTitle() }}</td>
                                <td>{{ $code->client->email }}</td>
                                <td>{{ $code->claim_details->get('page_id', '-') }}</td>
                                <td>{{ $code->claim_details->get('location', '-') }}</td>
                                <td>{{ $code->claim_details->get('country', '-') }}</td>
                                <td>{{ $code->claim_details->get('zip', '-') }}</td>
                                <td>{{ $code->claimed_on }}</td>
                                <td>{{ $code->getSEODescription(2) }}</td>
                                <td class="d-flex justify-content-end">
                                    @can('backend.codes.update')
                                    <a class="btn btn-info btn-icon btn-icon-md rounded-0"
                                        href="{{ route('admin.code.show', $code) }}" data-toggle="tooltip"
                                        data-placement="left"
                                        title="{{ __('basic.actions.view', ['name' => 'Code']) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @endcan
                                    @can('backend.codes.delete')
                                    <x-ui.button-delete :model="$code"
                                        :route-destroy="route('admin.code.destroy', $code)"
                                        :route-delete="route('admin.code.delete', $code)"
                                        :route-restore="route('admin.code.restore', $code)" model-name="Code"
                                        :identifier="$code->id" />
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $codes->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
