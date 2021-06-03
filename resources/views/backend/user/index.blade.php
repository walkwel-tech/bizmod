@extends('layouts.admin')

@section('content')
    @include('layouts.headers.cards')

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
                            <h3 class="mb-0">Users</h3>
                        </div>
                        @if($addNew)
                        <div class="col-4 text-right">
                            <a href="{{ route('admin.user.create') }}" class="btn btn-sm btn-primary">Add user</a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Creation Date</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>
                                    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                </td>
                                <td>{{ $user->created_at->toRfc7231String() }}</td>
                                <td class="d-flex justify-content-center">

                                    @can('backend.users.delete')
                                    <x-ui.button-delete :model="$user" :route-destroy="route('admin.user.destroy', $user)" :route-restore="route('admin.user.restore')" :route-delete="route('admin.user.delete')" model-name="User" :identifier="$user->id"/>
                                    @endcan

                                    <x-ui.dropdown>
                                        @can('backend.users.update')
                                        <a class="dropdown-item" href="{{ route('admin.user.show', $user) }}">Edit</a>
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
                        {{ $users->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
