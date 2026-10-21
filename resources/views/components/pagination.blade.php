<div class="w3-margin-top w3-center">
    {{-- Previous --}}
    @if ($items->onFirstPage())
        <span class="w3-button w3-light-gray w3-disabled">Previous</span>
    @else
        <a href="{{ $items->previousPageUrl() }}" class="w3-button w3-light-gray">Previous</a>
    @endif

    {{-- Pages --}}
    @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
        <a href="{{ $url }}" 
           class="w3-button {{ $page == $items->currentPage() ? 'w3-red' : 'w3-light-gray' }}">
            {{ $page }}
        </a>
    @endforeach

    {{-- Next --}}
    @if ($items->hasMorePages())
        <a href="{{ $items->nextPageUrl() }}" class="w3-button w3-light-gray">Next</a>
    @else
        <span class="w3-button w3-light-gray w3-disabled">Next</span>
    @endif
</div>
