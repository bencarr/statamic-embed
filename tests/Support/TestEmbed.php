<?php

namespace Tests\Support;

use BenCarr\Embed\Helpers\EmbedData;
use Illuminate\Contracts\Support\Arrayable;

class TestEmbed implements Arrayable
{
    public function __construct(
        public string $url = 'url',
        public bool $preview = true,
    ) {
    }

    public static function url(string $url)
    {
        return new self($url);
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'preview' => $this->preview,
        ];
    }

    public function toData()
    {
        return new EmbedData(...$this->toArray());
    }
}