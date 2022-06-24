<div class="flex gap-6">
    @if($embed->code || $embed->image)
        <div class="flex-1 max-w-1/2">
            @include('embed::components.media')
        </div>
    @endif
    <div class="flex-1 flex flex-col justify-center">
        @include('embed::components.title')
        @include('embed::components.byline')
        @include('embed::components.description')
    </div>
</div>
