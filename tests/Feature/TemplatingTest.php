<?php

use Illuminate\Support\Facades\Blade;
use Statamic\Facades\Antlers;
use Tests\Support\TestResponse;

it('outputs HTML code using Blade and Antlers', function ($type, $url, $output) {
    TestResponse::mock($type);
    $entry = pageWithEmbed($url);
    $context = ['embed' => $entry->embed];
    $blade = Blade::render('{{ $embed }}', $context);
    $antlers = (string) Antlers::parse('{{ embed }}', $context);

    expect($output)->toEqual($blade)->toEqual($antlers);
})->with([
    ['photo', 'https://www.flickr.com/p/1234567890', '<img src="https://images.flickr.com/photo" />'],
    ['video', 'https://www.youtube.com/watch?v=example123', '<iframe></iframe>'],
]);

it('allows accessing cache properties using Blade and Antlers', function () {
    TestResponse::mock('video');
    $entry = pageWithEmbed('https://www.youtube.com/watch?v=example123');
    $context = ['embed' => $entry->embed];
    $blade = Blade::render('Video on {{ $embed->providerName }} by {{ $embed->authorName }}', $context);
    $antlers = (string) Antlers::parse('Video on {{ embed.providerName }} by {{ embed.authorName }}', $context);

    expect('Video on YouTube by Statamic')->toEqual($blade)->toEqual($antlers);
});

it('chains attributes using Blade', function () {
    TestResponse::mock('photo');
    $entry = pageWithEmbed('https://www.flickr.com/p/1234567890');
    $context = ['embed' => $entry->embed];
    $template = Blade::render('{{ $embed->merge(["class" => "test"]) }}', $context);

    expect($template)->toEqual('<img src="https://images.flickr.com/photo" class="test" />');
});