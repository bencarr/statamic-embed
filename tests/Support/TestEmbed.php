<?php

namespace Tests\Support;

use BenCarr\Embed\Helpers\EmbedData;
use Illuminate\Contracts\Support\Arrayable;

class TestEmbed implements Arrayable
{
    public function __construct(
        public string $url = 'url',
    ) {
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
        ];
    }

    public function toData()
    {
        return new EmbedData(...$this->toArray());
    }
}