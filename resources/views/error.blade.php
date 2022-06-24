@extends('embed::layout')
@section('body')
    <div class="px-6 py-12">
        <div class="flex items-center justify-center gap-1 text-gray-500">
            <svg class="w-6 h-6 opacity-50"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3>{{ $exception->getMessage() }}</h3>
        </div>
    </div>
@endsection