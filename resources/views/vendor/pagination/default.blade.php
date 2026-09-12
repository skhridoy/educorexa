@if ($paginator->hasPages())
    @php
        $currentPage = $paginator->currentPage();
        $isLengthAware = method_exists($paginator, 'lastPage');
        $lastPage = $isLengthAware ? $paginator->lastPage() : ($currentPage + ($paginator->hasMorePages() ? 1 : 0));

        if ($lastPage <= 3) {
            $startPage = 1;
            $endPage = $lastPage;
        } else {
            if ($currentPage <= 1) {
                $startPage = 1;
                $endPage = 3;
            } elseif ($currentPage >= $lastPage) {
                $startPage = $lastPage - 2;
                $endPage = $lastPage;
            } else {
                $startPage = $currentPage - 1;
                $endPage = $currentPage + 1;
            }
        }
    @endphp

    <nav aria-label="{{ __('Pagination Navigation') }}" class="edu-pagination-nav">
        {{-- Desktop / Tablet View (>= 768px): Full Standard Pagination --}}
        <div class="d-none d-md-block">
            <ul class="pagination mb-0 flex-wrap">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="disabled page-item" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="disabled page-item" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="active page-item" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                    </li>
                @else
                    <li class="disabled page-item" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true">&rsaquo;</span>
                    </li>
                @endif
            </ul>
        </div>

        {{-- Mobile Responsive 3-Page Sliding Pagination (< 768px) --}}
        <div class="d-block d-md-none">
            <ul class="pagination pagination-sm mb-0 align-items-center justify-content-center">
                {{-- Previous Page Button --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link mobile-page-btn" aria-hidden="true">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link mobile-page-btn" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                    </li>
                @endif

                {{-- 3 Sliding Page Numbers --}}
                @for ($p = $startPage; $p <= $endPage; $p++)
                    @if ($p == $currentPage)
                        <li class="page-item active" aria-current="page">
                            <span class="page-link mobile-page-btn fw-bold">{{ $p }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link mobile-page-btn" href="{{ $paginator->url($p) }}">{{ $p }}</a>
                        </li>
                    @endif
                @endfor

                {{-- Next Page Button --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link mobile-page-btn" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link mobile-page-btn" aria-hidden="true">&rsaquo;</span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>

    @once
    <style>
        .edu-pagination-nav .pagination {
            gap: 2px;
        }
        .edu-pagination-nav .mobile-page-btn {
            min-width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 6px;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 6px;
            margin: 0 1px;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .edu-pagination-nav .page-item.active .mobile-page-btn {
            background: #4f46e5 !important;
            border-color: #4f46e5 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(79, 70, 229, 0.25) !important;
        }
        .edu-pagination-nav .page-item.disabled .mobile-page-btn {
            opacity: 0.4;
            cursor: not-allowed;
            background: transparent !important;
        }
        [data-bs-theme="dark"] .edu-pagination-nav .mobile-page-btn,
        body.dark-mode .edu-pagination-nav .mobile-page-btn {
            border-color: #334155;
            color: #cbd5e1;
            background: transparent;
        }
        [data-bs-theme="dark"] .edu-pagination-nav .mobile-page-btn:hover,
        body.dark-mode .edu-pagination-nav .mobile-page-btn:hover {
            background: #1e293b;
            color: #f8fafc;
        }
        [data-bs-theme="dark"] .edu-pagination-nav .page-item.active .mobile-page-btn,
        body.dark-mode .edu-pagination-nav .page-item.active .mobile-page-btn {
            background: #4f46e5 !important;
            border-color: #4f46e5 !important;
            color: #ffffff !important;
        }
    </style>
    @endonce
@endif
