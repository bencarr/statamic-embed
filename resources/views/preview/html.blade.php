@if($embed->code->ratio)
    <div class="relative [&>*]:absolute [&>*]:inset-0 [&>*]:w-full [&>*]:h-full rounded overflow-hidden shadow" style="padding-bottom: {{ $embed->code->ratio }}%">
        {!! $embed->code->html !!}
    </div>
@elseif($embed->code->width)
    <div class="mx-auto" style="max-width: {{ $embed->width }}px">
        {!! $embed->code->html !!}
    </div>
@else
    <div class="[&>*]:w-full">
        {!! $embed->code->html !!}
    </div>
@endif