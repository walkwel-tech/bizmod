@extends('layouts.app', ['navbar' => true, 'footer' => true])

@section('content')
<section class="container_brand">
    <div class="page_heading_inner d-flex justify-content-between">
    <!-- <h6>List Projects &nbsp;&nbsp;/&nbsp;&nbsp; <span>New <strong>Project</strong></span></h6>-->
    <a href="{{ route('frontend.services.create') }}" class="button button-md button-solid">Make Request</a>
        <a href="{{ route('frontend.services.index') }}" class="text-uppercase"><img src="{{ asset('images/green-arrow-left.png')}}" alt="" />{{ __('basic.actions.back', ['name' => 'Services']) }}</a>
    </div>

    <div class="form_card p-0">
        <section class="form_tab">
            <div class="form_tab_header">
                <h2>Service <span>{{ $service->getSEOTitle(25) }}</span></h2>
                <p>
                    <strong>Price:</strong> {{ $service->amount }}
                </p>
                <div class="project_action">
                    <ul class="d-flex">
                        @can('update', $service)
                        <li>
                            <a class="project_action_edit" href="{{ route('frontend.services.edit', $service) }}">
                                <span></span>
                                {{ __('basic.actions.update', ['name' => 'Service']) }}
                            </a>
                        </li>
                        @endcan
                        @can('delete', $service)
                        <li>
                            <a class="project_action_delete" href="{{ route('frontend.services.destroy', $service) }}">
                                <span></span>
                                {{ __('basic.actions.delete', ['name' => 'Service']) }}
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </div>

            <div class="form_tab_wrapper">
                <ul class="nav nav-tabs" role="tablist">

                    <li role="presentation" class="nav-item">
                        <a class="nav-link" data-toggle="tab" role="tab" href="#service_description" aria-selected="false"
                            aria-controls="service_description" id="project_summary_tab"><span></span>Description</a>
                    </li>
                </ul>

                <div id="content" class="tab-content" role="tablist">

                    <div id="service_description" class="card tab-pane fade show active" role="tabpanel"
                        aria-labelledby="service_description_tab">
                        {{ $service->getSEODescription(10) }}

                    </div>
                </div>
            </div>
        </section>
    </div>


</section>
@endsection

@push('js')
<script>
    //open and close tab menu
    $(document).ready(function () {
        $('.nav-tabs-dropdown')
            .on("click", "a:not('.active')", function (event) {
                $(this).parents('ul').removeClass("open");
            })
            .on("click", "a.active", function (event) {
                $(this).parents('ul').toggleClass("open");
            });

        function resize() {
            $(".modal-body").css({
                height: $(window).height() - 160
            });
            $(".table-hr-scroll").css({
                height: $(window).height() - 586
            });
        }
        resize();
        $(window).resize(function () {
            resize();
        });
    })

</script>
@endpush
