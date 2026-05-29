@if ($paginator->hasPages())
    <div class="flex items-center justify-center gap-1 sm:gap-1.5 py-2">
        {{-- First Page --}}
        @if (!$paginator->onFirstPage())
            <a href="{{ $paginator->url(1) }}"
                class="w-8 h-8 flex items-center justify-center text-gray-500 bg-white border border-gray-200 rounded-md hover:bg-emerald-50 hover:text-emerald-600 transition-all font-medium"
                title="Halaman Pertama">
                <i class="fa-solid fa-angles-left text-[10px]"></i>
            </a>
        @endif

        {{-- Previous Page --}}
        @if ($paginator->onFirstPage())
            <span
                class="w-8 h-8 flex items-center justify-center text-gray-300 bg-gray-50 border border-gray-100 rounded-md cursor-not-allowed">
                <i class="fa-solid fa-angle-left text-xs"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="w-8 h-8 flex items-center justify-center text-gray-500 bg-white border border-gray-200 rounded-md hover:bg-emerald-50 hover:text-emerald-600 transition-all font-medium">
                <i class="fa-solid fa-angle-left text-xs"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span
                    class="w-8 h-8 flex items-center justify-center text-gray-400 text-[10px] font-bold bg-white border border-gray-200 rounded-md cursor-default">
                    {{ $element }}
                </span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span
                            class="w-8 h-8 flex items-center justify-center text-white bg-emerald-600 border border-emerald-600 rounded-md font-bold z-10 text-xs">
                            {{ $page }}
                        </span>
                    @else
                        @if (abs($page - $paginator->currentPage()) <= 1 || $page == 1 || $page == $paginator->lastPage())
                            <a href="{{ $url }}"
                                class="w-8 h-8 flex items-center justify-center text-gray-600 bg-white border border-gray-200 rounded-md hover:bg-emerald-50 hover:text-emerald-600 transition-all font-medium text-xs">
                                {{ $page }}
                            </a>
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="w-8 h-8 flex items-center justify-center text-gray-500 bg-white border border-gray-200 rounded-md hover:bg-emerald-50 hover:text-emerald-600 transition-all font-medium">
                <i class="fa-solid fa-angle-right text-xs"></i>
            </a>
        @else
            <span
                class="w-8 h-8 flex items-center justify-center text-gray-300 bg-gray-50 border border-gray-100 rounded-md cursor-not-allowed">
                <i class="fa-solid fa-angle-right text-xs"></i>
            </span>
        @endif

        {{-- Last Page --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->url($paginator->lastPage()) }}"
                class="w-8 h-8 flex items-center justify-center text-gray-500 bg-white border border-gray-200 rounded-md hover:bg-emerald-50 hover:text-emerald-600 transition-all font-medium"
                title="Halaman Terakhir">
                <i class="fa-solid fa-angles-right text-[10px]"></i>
            </a>
        @endif
    </div>
@endif
