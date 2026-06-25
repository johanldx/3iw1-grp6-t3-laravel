@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex items-center gap-2 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm text-gray-400">
                    {{ __('pagination.previous') }}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    {{ __('pagination.previous') }}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    {{ __('pagination.next') }}
                </a>
            @else
                <span class="inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm text-gray-400">
                    {{ __('pagination.next') }}
                </span>
            @endif
        </div>

        <div class="hidden w-full items-center justify-between sm:flex">
            <p class="text-sm text-gray-600">
                {{ __('Showing') }}
                @if ($paginator->firstItem())
                    <span class="font-semibold text-gray-800">{{ $paginator->firstItem() }}</span>
                    {{ __('to') }}
                    <span class="font-semibold text-gray-800">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                {{ __('of') }}
                <span class="font-semibold text-gray-800">{{ $paginator->total() }}</span>
                {{ __('results') }}
            </p>

            <div class="inline-flex items-center overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                @if ($paginator->onFirstPage())
                    <span class="inline-flex items-center border-r border-gray-200 px-3 py-2 text-gray-300">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center border-r border-gray-200 px-3 py-2 text-gray-500 hover:bg-gray-50 hover:text-gray-700" aria-label="{{ __('pagination.previous') }}">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="inline-flex items-center border-r border-gray-200 px-4 py-2 text-sm text-gray-400">
                            {{ $element }}
                        </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="inline-flex items-center border-r border-gray-200 bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-900">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="inline-flex items-center border-r border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-3 py-2 text-gray-500 hover:bg-gray-50 hover:text-gray-700" aria-label="{{ __('pagination.next') }}">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @else
                    <span class="inline-flex items-center px-3 py-2 text-gray-300">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
