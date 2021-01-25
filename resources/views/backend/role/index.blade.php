@extends('layouts.admin')

@section('content')
<x-page-header title="Roles" class="col-lg-7"
    :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Roles</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('admin.role.create') }}" class="btn btn-sm btn-primary">Add role</a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td class="d-flex justify-content-end">
                                    @can('backend.roles.delete')
                                    <x-ui.button-delete :model="$role" :route-destroy="route('admin.role.destroy', $role)" model-name="Role" :identifier="$role->id"/>
                                    @endcan

                                    <x-ui.dropdown>
                                        @can('backend.roles.update')
                                        <a class="dropdown-item" href="{{ route('admin.role.show', $role) }}">Edit</a>
                                        @endcan
                                    </x-ui.dropdown>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $roles->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
