@extends('layouts.admin')

@section('content')
<x-page-header title="Service Orders" class="col-lg-7"
    :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Service Orders</h3>
                        </div>
                        @if($addNew)
                        <div class="col-4 text-right">
                            <a href="{{ route('admin.serviceorder.create') }}" class="btn btn-sm btn-primary">Add Order</a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Price</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($service_orders as $service_order)
                            <tr>
                                <td>{{ $service_order->customer_name }}</td>
                                <td>{{ $service_order->getSEODescription(2) }}</td>
                                <td>{{ $service_order->amount }}</td>
                                <td class="d-flex justify-content-end">
                                    @can('backend.service_orders.update')
                                    <a class="btn btn-info btn-icon btn-icon-md rounded-0" href="{{ route('admin.serviceorder.show', $service_order) }}" data-toggle="tooltip" data-placement="left" title="{{ __('basic.actions.view', ['name' => 'ServiceOrder']) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @endcan
                                    @can('backend.service_orders.delete')
                                    <x-ui.button-delete :model="$service_order" :route-destroy="route('admin.serviceorder.destroy', $service_order)" :route-delete="route('admin.serviceorder.delete', $service_order)" :route-restore="route('admin.serviceorder.restore', $service_order)" model-name="ServiceOrder" :identifier="$service_order->id"/>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $service_orders->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
