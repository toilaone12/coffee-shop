<div class="row mt-5">
    <div class="col text-center">
        <div class="block-27">
            <ul>
                @if ($paginator->onFirstPage())
                <li class="disabled"><a href="#">&lt;&lt;</a></li>
                @else
                <li><a href="{{ $paginator->url(1) }}">&lt;&lt;</a></li>
                @endif
                @if ($paginator->onFirstPage())
                <li class="disabled"><a href="#">&lt;</a></li>
                @else
                <li><a href="{{ $paginator->previousPageUrl() }}">&lt;</a></li>
                @endif
                @foreach ($elements as $element)
                @if (is_string($element))
                <li class="disabled">{{ $element }}</li>
                @endif

                @if (is_array($element))
                @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <li class="active"><a href="#">{{ $page }}</a></li>
                @else
                <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
                @endforeach
                @endif
                @endforeach
                @if ($paginator->hasMorePages())
                    <li><a href="{{ $paginator->nextPageUrl() }}">&gt;</a></li>
                @else
                    <li class="disabled"><a href="#">&gt;</a></li>
                @endif
                @if ($paginator->hasMorePages())
                    <li><a href="{{ $paginator->url($paginator->lastPage()) }}">&gt;&gt;</a></li>
                @else
                    <li class="disabled"><a href="#">&gt;&gt;</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>