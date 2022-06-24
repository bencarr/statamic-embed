@if($embed->authorName)
    @if($embed->authorUrl)
        <a href="{{ $embed->authorUrl }}" class="hover:underline" target="_blank">{{ $embed->authorName }}</a>
    @else
        <span>{{ $embed->authorName }}</span>
    @endif
@endif