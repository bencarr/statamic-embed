@extends('embed::layout')
@section('body')
    @includeFirst([
        'embed::provider.'.str($embed->providerName)->slug(),
        'embed::provider.default',
    ])
@endsection