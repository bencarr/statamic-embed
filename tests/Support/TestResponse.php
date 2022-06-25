<?php

namespace Tests\Support;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class TestResponse
{
    public function __construct(array $responses = [])
    {
        // Create a mock and queue two responses.
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);
        config()->set('statamic.embed.client_settings', ['handler' => $handlerStack]);
    }

    public static function mock($types): self
    {
        $responses = collect($types)
            ->map(function ($key) {
                $type = str($key)->before(':')->toString();
                $args = str($key)->after(':')->explode(',')->toArray();

                return (new self)->$type(...$args);
            })
            ->flatMap(fn($response) => [$response, $response]) // Double up for oEmbed Discovery ping
            ->toArray();

        return new self($responses);
    }

    public static function void(): self
    {
        return new self();
    }

    public function video(): Response
    {
        return $this->toResponse([
            'version' => '1.0',
            'type' => 'video',
            'provider_name' => 'YouTube',
            'provider_url' => 'https://www.youtube.com',
            'width' => 800,
            'height' => 450,
            'title' => 'Example Video',
            'author_name' => 'Statamic',
            'author_url' => 'https://youtube.com/user/statamic',
            'html' => '<iframe></iframe>',
        ]);
    }

    public function photo(): Response
    {
        return $this->toResponse('
            <html>
            <head>
                <meta name="og:title" content="Example Photo" />
                <meta name="og:image" content="https://images.flickr.com/photo" />
            </head>
            </html>
        ');
    }

    public function toResponse($data): Response
    {
        if (is_string($data)) {
            return new Response(200, [], $data);
        }

        return new Response(200, ['Content-type' => 'application/json'], json_encode($data));
    }
}