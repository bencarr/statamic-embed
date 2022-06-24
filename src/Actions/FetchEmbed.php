<?php

namespace BenCarr\Embed\Actions;

use Embed\Embed;
use Embed\Extractor;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Cache;

class FetchEmbed
{
    protected Repository $cache;

    public function __construct(
        public string $url
    ) {
        $this->cache = Cache::store(config('statamic.embed.cache.driver'));
        $this->ttl = config('statamic.embed.cache.ttl');
    }

    public static function url(string $url)
    {
        return new self($url);
    }

    public function get()
    {
        if ($this->ttl) {
            return $this->cache->remember($this->getCacheKey(), $this->ttl, fn() => $this->fetch());
        }

        return $this->cache->rememberForever($this->getCacheKey(), fn() => $this->fetch());
    }

    public function fetch()
    {
        $embed = app(Embed::class);
        $info = $embed->get($this->url);

        $response = $info->getResponse();
        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw new HttpClientException($response->getReasonPhrase(), $response->getStatusCode());
        }

        return $this->transform($info);
    }

    public function refresh()
    {
        Cache::forget($this->getCacheKey());

        return $this->get();
    }

    protected function transform(Extractor $response): object
    {
        return (object) [
            'authorName' => $response->authorName,
            'authorUrl' => $response->authorUrl,
            'cms' => $response->cms,
            'code' => $response->code,
            'description' => $response->description,
            'favicon' => $response->favicon,
            'feeds' => $response->feeds,
            'icon' => $response->icon,
            'image' => $response->image,
            'keywords' => $response->keywords,
            'language' => $response->language,
            'languages' => $response->languages,
            'license' => $response->license,
            'providerName' => $response->providerName,
            'providerUrl' => $response->providerUrl,
            'publishedTime' => $response->publishedTime,
            'redirect' => $response->redirect,
            'title' => $response->title,
            'url' => $response->url,
        ];
    }

    protected function getCacheKey()
    {
        return str($this->url)->lower()->prepend('embed.');
    }
}