@extends('layouts.admin')

@section('content')
<x-page-header title="Steps" class="col-lg-7"
    :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Steps</h3>
                        </div>
                        @if($addNew)
                        <div class="col-4 text-right">
                            <a href="{{ route('admin.step.create') }}" class="btn btn-sm btn-primary">Add Step</a>
                        </div>
                        @endif
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
                                <th scope="col">Service</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($steps as $step)
                            <tr>
                                <td>{{ $step->getSEOTitle() }}</td>
                                <td>{{ $step->getSEODescription(2)  }}</td>
                                <td>{{ $step->getSEOContent(2)  }}</td>
                                <td>{{ $step->order  }}</td>
                                <td>@if($step->submitable ==1) Yes @else No @endif</td>
                                <td> {{ $step->service->getSEOTitle() }}</td>
                                <td class="d-flex justify-content-end">
                                    @can('backend.steps.update')
                                    <a class="btn btn-info btn-icon btn-icon-md rounded-0" href="{{ route('admin.step.show', $step) }}" data-toggle="tooltip" data-placement="left" title="{{ __('basic.actions.view', ['name' => 'Step']) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @endcan
                                    @can('backend.steps.delete')
                                    <x-ui.button-delete :model="$step" :route-destroy="route('admin.step.destroy', $step)" :route-delete="route('admin.step.delete', $step)" :route-restore="route('admin.step.restore', $step)" model-name="Step" :identifier="$step->id"/>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $steps->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
