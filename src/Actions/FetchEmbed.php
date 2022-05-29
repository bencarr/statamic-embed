<?php

namespace BenCarr\Embed\Actions;

use Embed\Embed;
use Embed\Extractor;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Cache;

class FetchEmbed
{
    public function __construct(
        public string $url
    ) {
    }

    public static function url(string $url)
    {
        return new self($url);
    }

    public function get()
    {
        return Cache::rememberForever($this->getCacheKey(), function () {
            $embed = (new Embed)->get($this->url);
            $response = $embed->getResponse();
            if ($response->getStatusCode() < 200 && $response->getStatusCode() >= 300) {
                throw new HttpClientException($response->getReasonPhrase(), $response->getStatusCode());
            }

            return $this->transform($embed);
        });
    }

    public function refresh()
    {
        Cache::forget($this->getCacheKey());

        return $this->get();
    }

    protected function transform(Extractor $response)
    {
        return [
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