<?php

return [
    'settings' => [],
    'client_settings' => [],
    'cache' => [
        'driver' => env('EMBED_CACHE_DRIVER'),
        'ttl' => env('EMBED_CACHE_TTL', 0),
    ],
];