<?php

namespace BenCarr\Embed\Helpers;

use Embed\Extractor;
use Illuminate\Contracts\Support\Arrayable;

class EmbedCache implements Arrayable
{
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function from(Extractor $extractor)
    {
        return new self([
            'authorName' => $extractor->authorName,
            'authorUrl' => (string) $extractor->authorUrl,
            'cms' => $extractor->cms,
            'code' => $extractor->code ? (object) $extractor->code : null,
            'description' => $extractor->description,
            'favicon' => (string) $extractor->favicon,
            'feeds' => (array) $extractor->feeds,
            'icon' => (string) $extractor->icon,
            'image' => (string) $extractor->image,
            'keywords' => (array) $extractor->keywords,
            'language' => $extractor->language,
            'languages' => (array) $extractor->languages,
            'license' => $extractor->license,
            'providerName' => $extractor->providerName,
            'providerUrl' => (string) $extractor->providerUrl,
            'publishedTime' => $extractor->publishedTime,
            'redirect' => $extractor->redirect,
            'title' => $extractor->title,
            'url' => (string) $extractor->url,
        ]);
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
