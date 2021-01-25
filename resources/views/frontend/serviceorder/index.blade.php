@extends('layouts.app', ['navbar' => true, 'footer' => true])

@section('content')
<section class="container_brand">
    <div class="page_heading d-flex justify-content-between">
        <h2><strong>Services</strong> <span>{{ $services->count() }}</span></h2>

        @can('create', App\Service::class)
        <a href="{{ route('frontend.services.create') }}" class="button button-md button-solid">
            <img src="{{ asset('images/plus-icon.png')}}" alt="" />Create Service
        </a>
        @endcan
    </div>

    <div class="service_table">
        <table class="projects">
            <thead>
                <tr>
                    <th>Service Name</th>
                    <th class="details-hide-md">Description</th>
                    <th >Price</th>

                    <th class="action-flex" width="200">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    @include('frontend.service.table-item', ['service' => $service])
                @empty
                    <tr>
                        <td class="project_details text-center bg-light text-muted" colspan="6">{{ __('pagination.empty') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="container_brand">
            {{ $services->links('layouts.pagination.services') }}
        </div>
    </div>
</section>
@endsection
