<tr>
    <td class="project_details">
        <div class="project_details_box d-flex">
            <img src="{{ asset('images/dummy-img.jpg') }}" alt="">
            <div class="project_id d-flex flex-column justify-content-center">
                <h5>{{ $service->getSEOTitle(27) }}</h5>
                <label for="">#{{ $service->getKey() }}</label>
            </div>
        </div>
    </td>
    <td class="project_date details-hide-sm">
        {{ $service->getSEODescription(10) }}
    </td>

    <td class="project_price ">
    <p> {{ $service->amount }}</p>
    </td>

    <td class="project_action">
        <ul class="d-flex">

            <li>
                <a class="project_action_view" href="{{ route('frontend.service.show', $service) }}">
                    <span></span>
                    View
                </a>
            </li>
            <li>
                <a class="project_action_order" href="{{ route('frontend.serviceorder.create', $service) }}">
                    <span></span>
                    Make Request
                </a>
            </li>


            @can('delete', $service)
            <li>
                <a class="project_action_delete" href="{{ route('frontend.service.destroy', $service) }}">
                    <span></span>
                    Delete
                </a>
            </li>
            @endcan
        </ul>
    </td>
</tr>
