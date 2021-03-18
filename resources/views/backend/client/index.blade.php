@extends('layouts.admin')

@section('content')
<x-page-header title="Clients" class="col-lg-7"
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
                                        <x-form.filter :allowedFilters="$allowedFilters" :searchedParams="$searchedParams" />

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
                            <h3 class="mb-0">Clients</h3>
                        </div>




                        @if($addNew)
                        <div class="col-4 text-right">

                            <a href="{{ route('admin.client.create') }}" class="btn btn-sm btn-primary">Add Client</a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Country</th>
                                <th scope="col">Zip</th>
                                <th scope="col">Business</th>
                                <th scope="col"></th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                            <tr>
                                <td>{{ $client->first_name }}</td>
                                <td>{{ $client->last_name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ $client->country_name }}</td>
                                <td>{{ $client->zip }}</td>
                                <td>{{ $client->businessTitles }}</td>
                                <td class="d-flex justify-content-end">
                                    @can('backend.clients.update')
                                    <a class="btn btn-info btn-icon btn-icon-md rounded-0" href="{{ route('admin.client.show', $client) }}" data-toggle="tooltip" data-placement="left" title="{{ __('basic.actions.view', ['name' => 'Client']) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @endcan
                                    @can('backend.clients.delete')
                                    <x-ui.button-delete :model="$client" :route-destroy="route('admin.client.destroy', $client)" :route-delete="route('admin.client.delete', $client)" :route-restore="route('admin.client.restore', $client)" model-name="Client" :identifier="$client->id"/>
                                    @endcan
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $clients->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
