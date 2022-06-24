@if($embed->title)
    <h1 class="text-lg leading-tight font-bold">
        @if($embed->url)
            <a href="{{ $embed->url }}" class="hover:underline" target="_blank">{{ $embed->title }}</a>
        @else
            {{ $embed->title }}
        @endif
    </h1>
@endif