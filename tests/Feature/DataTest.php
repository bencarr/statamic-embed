<?php

use BenCarr\Embed\Actions\EmbedManager;
use BenCarr\Embed\Helpers\EmbedCache;
use Illuminate\Support\Facades\Cache;
use Tests\Support\TestResponse;

it('reuses cache keys for different capitalization of the same URL', function (...$urls) {
    $keys = collect($urls)->map(fn($url) => EmbedManager::key($url));
    expect($keys->unique()->count())->toEqual(1);
})->with([
    ['http://example.com', 'HTTP://EXAMPLE.COM', 'hTtP://eXaMpLe.CoM'],
]);

it('caches fetched embeds', function () {
    TestResponse::mock('video');
    $url = 'https://youtube.com/watch?v=example123';
    $cacheKey = EmbedManager::key($url);

    expect(Cache::has($cacheKey))->toBeFalse();

    $embed = EmbedManager::url($url)->get();
    expect($embed)->toBeInstanceOf(EmbedCache::class);
    expect(Cache::has($cacheKey))->toBeTrue();
});