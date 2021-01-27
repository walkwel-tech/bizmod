@extends('layouts.admin')

@section('content')
<x-page-header title="Codes" class="col-lg-7"
    :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Codes</h3>
                        </div>
                        @if($addNew)
                        <div class="col-4 text-right">
                            <a href="{{ route('admin.code.create') }}" class="btn btn-sm btn-primary">Add Code</a>
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
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($codes as $code)
                            <tr>
                                <td>{{ $code->batch_no }}</td>
                                <td>{{ $code->code }}</td>
                                <td>{{ $code->business->getSEOTitle() }}</td>
                                <td class="d-flex justify-content-end">
                                    @can('backend.codes.update')
                                    <a class="btn btn-info btn-icon btn-icon-md rounded-0" href="{{ route('admin.code.show', $code) }}" data-toggle="tooltip" data-placement="left" title="{{ __('basic.actions.view', ['name' => 'Code']) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @endcan
                                    @can('backend.codes.delete')
                                    <x-ui.button-delete :model="$code" :route-destroy="route('admin.code.destroy', $code)" :route-delete="route('admin.code.delete', $code)" :route-restore="route('admin.code.restore', $code)" model-name="Code" :identifier="$code->id"/>
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
