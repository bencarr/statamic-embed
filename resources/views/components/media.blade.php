@if($embed->code)
    @include('embed::preview.html')
@elseif($embed->image)
    @include('embed::preview.image')
@endif
