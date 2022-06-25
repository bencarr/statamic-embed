<?php

namespace BenCarr\Embed\Helpers;

use BenCarr\Embed\Actions\EmbedManager;
use BenCarr\Embed\Concerns\HasChainableAttributes;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

class EmbedData implements Arrayable, Htmlable
{
    use HasChainableAttributes;

    public EmbedCache $cache;

    public function __construct(
        public string $url,
        public bool $preview = true,
    ) {
        $this->initChainableAttributes();
        $this->cache = EmbedManager::url($url)->get();
    }

    public function toHtml()
    {
        if ($code = $this->cache->code) {
            return $code->html;
        }

        if ($image = $this->cache->image) {
            return sprintf('<img %s />', $this->attributes->merge([
                'src' => $image,
                'alt' => $this->cache->description,
            ]));
        }

        return sprintf('<a %s>%s</a>', $this->attributes->merge([
            'href' => $this->url,
            'target' => '_blank',
        ]), $this->url);
    }

    public function __get(string $name)
    {
        return $this->cache->$name;
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }

    public function toArray(): array
    {
        return $this->cache->toArray();
    }
}
