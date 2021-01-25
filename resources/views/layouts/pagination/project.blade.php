@if ($paginator->hasPages())
    <div class="pagination d-flex justify-content-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <a href="#" class="pagination-prev disabled" aria-disabled="true" aria-label="@lang('pagination.previous')"><img src="{{ asset('images/paginaton-left.png') }}" alt="@lang('pagination.previous')"></a>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" class="pagination-prev"  aria-label="@lang('pagination.previous')"><img src="{{ asset('images/paginaton-left.png') }}" alt="@lang('pagination.previous')"></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <a href="#" class="pagination-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="#" class="active"  aria-current="page">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')" class="pagination-next"><img src="{{ asset('images/paginaton-right.png') }}" alt="@lang('pagination.next')"></a>
        @else
            <a href="#" rel="next" aria-label="@lang('pagination.next')" class="pagination-next disabled"><img src="{{ asset('images/paginaton-right.png') }}" alt="@lang('pagination.next')"></a>
        @endif
    </div>
@endif
