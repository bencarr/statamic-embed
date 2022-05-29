<?php

namespace BenCarr\Embed\Helpers;

use BenCarr\Embed\Concerns\HasChainableAttributes;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

class EmbedData implements Arrayable, Htmlable
{
    use HasChainableAttributes;

    public function __construct(
        public string $url,
    ) {
        $this->initChainableAttributes();
    }

    public function toHtml()
    {
        return sprintf('<a %s>%s</a>', $this->attributes->merge([
            'href' => $this->url,
        ]), $this->url);
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
        ];
    }
}
