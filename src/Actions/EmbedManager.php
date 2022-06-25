<?php

namespace BenCarr\Embed\Actions;

use BenCarr\Embed\Helpers\EmbedCache;
use Embed\Embed;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Cache;

class EmbedManager
{
    protected Repository $cache;

    protected string $cacheKey;

    public function __construct(
        public string $url
    ) {
        $this->cache = Cache::store(config('statamic.embed.cache.driver'));
        $this->ttl = config('statamic.embed.cache.ttl');
        $this->cacheKey = self::key($url);
    }

    public static function url(string $url)
    {
        return new self($url);
    }

    public function get()
    {
        if ($this->ttl) {
            return $this->cache->remember($this->cacheKey, $this->ttl, fn() => $this->fetch());
        }

        return $this->cache->rememberForever($this->cacheKey, fn() => $this->fetch());
    }

    public function fetch()
    {
        $embed = app(Embed::class);
        $info = $embed->get($this->url);

        $response = $info->getResponse();
        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw new HttpClientException($response->getReasonPhrase(), $response->getStatusCode());
        }

        return EmbedCache::from($info);
    }

    public function refresh()
    {
        Cache::forget($this->cacheKey);

        return $this->get();
    }

    public static function key(string $url): string
    {
        return str($url)->lower()->prepend('embed.')->toString();
    }
}