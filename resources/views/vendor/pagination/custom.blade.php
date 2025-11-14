@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-2 text-sm mt-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 text-gray-400 rounded cursor-not-allowed"><img src="{{ asset('assets/images/icons/arrow_left.svg') }}" alt="" class="w-4 h-4"></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 border rounded hover:bg-gray-200"><img src="{{ asset('assets/images/icons/arrow_left.svg') }}" alt="" class="w-4 h-4"></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-400">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 bg-[#ded6fa] text-[#998cd5] rounded">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 border rounded hover:bg-gray-200">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 border rounded hover:bg-gray-200"><img src="{{ asset('assets/images/icons/arrow_right.svg') }}" alt="" class="w-4 h-4"></a>
        @else
            <span class="px-3 py-1 text-gray-400 rounded cursor-not-allowed"><img src="{{ asset('assets/images/icons/arrow_right.svg') }}" alt="" class="w-4 h-4"></span>
        @endif
    </nav>
@endif
