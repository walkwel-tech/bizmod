@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <div class="container mt--10 pb-5">
        Saying Hello from {{ config('app.name', 'Laravel App') }}
    </div>
@endsection
