<?php

use BenCarr\Embed\Actions\EmbedManager;
use Illuminate\Support\Facades\Blade;
use Tests\Support\TestResponse;

it('renders live previews of links', function ($type, $url, ...$contains) {
    TestResponse::mock($type);
    $embed = EmbedManager::url($url)->get();
    $template = Blade::render('embed::preview', ['embed' => $embed]);

    expect($template)->toContain(...$contains);
})->with([
    ['video', 'https://www.youtube.com/watch?v=example123', '<iframe', 'Example Video'],
    ['photo', 'https://www.flickr.com/p/123456789', '<img', 'Example Photo'],
]);