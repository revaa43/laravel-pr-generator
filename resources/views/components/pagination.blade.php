@if ($paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $paginator->hasPages())
@php
    $window = \Illuminate\Pagination\UrlWindow::make($paginator);
    $elements = array_filter([
        $window['first'],
        is_array($window['slider']) ? '...' : null,
        $window['slider'],
        is_array($window['last']) ? '...' : null,
        $window['last'],
    ]);
@endphp
    <nav role="navigation" aria-label="Pagination" class="flex items-center justify-between px-2 py-4">

        {{-- Info --}}
        <div class="text-sm text-secondary-500">
            Showing
            <span class="font-semibold text-secondary-700">{{ $paginator->firstItem() }}</span>
            to
            <span class="font-semibold text-secondary-700">{{ $paginator->lastItem() }}</span>
            of
            <span class="font-semibold text-secondary-700">{{ $paginator->total() }}</span>
            results
        </div>

        {{-- Buttons --}}
        <div class="flex items-center gap-1">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-2 py-1.5 text-sm font-medium text-secondary-300 bg-white border border-secondary-200 rounded-lg cursor-not-allowed select-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center px-2 py-1.5 text-sm font-medium text-secondary-600 bg-white border border-secondary-200 rounded-lg hover:bg-orange-light-50 hover:text-primary-600 hover:border-primary-300 transition-colors duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="inline-flex items-center px-3 py-1.5 text-sm text-secondary-400 bg-white border border-secondary-200 rounded-lg cursor-default">
                        {{ $element }}
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-white bg-primary-500 border border-primary-500 rounded-lg cursor-default shadow-orange">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-secondary-700 bg-white border border-secondary-200 rounded-lg hover:bg-orange-light-50 hover:text-primary-600 hover:border-primary-300 transition-colors duration-150">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center px-2 py-1.5 text-sm font-medium text-secondary-600 bg-white border border-secondary-200 rounded-lg hover:bg-orange-light-50 hover:text-primary-600 hover:border-primary-300 transition-colors duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <span class="inline-flex items-center px-2 py-1.5 text-sm font-medium text-secondary-300 bg-white border border-secondary-200 rounded-lg cursor-not-allowed select-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            @endif

        </div>
    </nav>
@endif