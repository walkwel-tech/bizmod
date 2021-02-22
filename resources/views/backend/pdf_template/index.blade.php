@extends('layouts.admin')

@section('content')
<x-page-header title="Pdf Template" class="col-lg-7"
    :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">

                        <div class="col-8">
                            <h3 class="mb-0">Pdf Template</h3>
                        </div>
                        @if($addNew)
                        <div class="col-4 text-right">
                            <a href="{{ route('admin.template.create') }}" class="btn btn-sm btn-primary">Add Template</a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Business</th>
                                <th scope="col">Path</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pdf_templates as $pdf_template)
                            <tr>
                                <td>{{ $pdf_template->getSEOTitle() }}</td>
                                <td>{{ $pdf_template->getSEODescription(2) }}</td>
                                <td>{{ $pdf_template->business->getSEOTitle() }}</td>
                                <td><a href="{{ route('admin.template.default', $pdf_template) }}" target="_blank">{{ $pdf_template->path }}</a></td>

                                <td class="d-flex justify-content-end">
                                    @can('backend.pdf_templates.update')
                                    <a class="btn btn-info btn-icon btn-icon-md rounded-0" href="{{ route('admin.template.show', $pdf_template) }}" data-toggle="tooltip" data-placement="left" title="{{ __('basic.actions.view', ['name' => 'Pdf Template']) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @endcan
                                    @can('backend.pdf_templates.delete')
                                    @if(!$pdf_template->is_assigned)
                                        <x-ui.button-delete :model="$pdf_template" :route-destroy="route('admin.template.destroy', $pdf_template)" :route-delete="route('admin.template.delete', $pdf_template)" :route-restore="route('admin.template.restore', $pdf_template)" model-name="PdfTemplate" :identifier="$pdf_template->id"/>
                                    @endif
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $pdf_templates->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
