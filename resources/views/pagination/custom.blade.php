@if ($paginator->hasPages())
    <nav aria-label="Pagination" class="d-flex justify-content-center">
        <ul class="pagination mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link rounded-pill me-2" style="background-color: rgba(44, 62, 80, 0.5); border: none; color: rgba(255, 255, 255, 0.5);">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded-pill me-2" href="{{ $paginator->previousPageUrl() }}" rel="prev" 
                       style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link rounded-pill me-2" style="background-color: #3498db; border: none;">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link rounded-pill me-2" href="{{ $url }}" 
                                   style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded-pill" href="{{ $paginator->nextPageUrl() }}" rel="next"
                       style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link rounded-pill" style="background-color: rgba(44, 62, 80, 0.5); border: none; color: rgba(255, 255, 255, 0.5);">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif