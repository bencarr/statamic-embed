<?php

use Embed\Http\CurlClient;

return [
    'client' => [
        'class' => CurlClient::class,
        'settings' => [],
    ],
    'settings' => [],
    'cache' => [
        'driver' => null,
        'ttl' => 0,
    ],
];