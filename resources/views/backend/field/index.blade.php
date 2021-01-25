@extends('layouts.admin')

@section('content')
<x-page-header title="Fields" class="col-lg-7"
    :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Fields</h3>
                        </div>
                        @if($addNew)
                        <div class="col-4 text-right">
                            <a href="{{ route('admin.field.create') }}" class="btn btn-sm btn-primary">Add Field</a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">Placeholder</th>
                                <th scope="col">Required</th>
                                <th scope="col">Step</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fields as $field)
                            <tr>
                                <td>{{ $field->getSEOTitle() }}</td>
                                <td>{{ $field->name }}</td>
                                <td>{{ $field->type }}</td>
                                <td>{{ $field->placeholder }}</td>
                                <td>@if($field->required==1)Yes @else No @endif</td>
                                <td> {{ $field->step->getSEOTitle() }}</td>
                                <td class="d-flex justify-content-end">
                                    @can('backend.fields.update')
                                    <a class="btn btn-info btn-icon btn-icon-md rounded-0" href="{{ route('admin.field.show', $field) }}" data-toggle="tooltip" data-placement="left" title="{{ __('basic.actions.view', ['name' => 'Field']) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @endcan
                                    @can('backend.fields.delete')
                                    <x-ui.button-delete :model="$field" :route-destroy="route('admin.field.destroy', $field)" :route-delete="route('admin.field.delete', $field)" :route-restore="route('admin.field.restore', $field)" model-name="Field" :identifier="$field->id"/>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $fields->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
