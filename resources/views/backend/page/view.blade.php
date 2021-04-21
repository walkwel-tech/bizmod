@extends('layouts.admin', ['title' => __('Page')])

@section('content')
<x-page-header title="{{ $page->getSEOTitle() }}" class="col-lg-7"
    :image-url="asset('argon/img/theme/profile-cover.jpg')" />

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-secondary shadow">

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            {!! $page->getCompleteContentFormated() !!}.
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
