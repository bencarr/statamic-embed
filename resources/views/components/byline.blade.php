<div class="text-sm font-medium text-gray-600 mb-2">
    @if($embed->authorName && $embed->providerName)
        <div class="flex items-center space-x-4">
            @include('embed::components.provider')
            @include('embed::components.author')
        </div>
    @elseif($embed->authorName)
        @include('embed::components.author')
    @elseif($embed->providerName)
        @include('embed::components.provider')
    @endif
</div>