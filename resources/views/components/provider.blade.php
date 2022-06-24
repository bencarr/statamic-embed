<div class="inline-flex items-center space-x-2">
    @if($icon = $embed->icon ?? $embed->favicon)
        <img src="{{ $icon }}" class="w-4 h-4"/>
    @endif
    <span>{{ $embed->providerName }}</span>
</div>