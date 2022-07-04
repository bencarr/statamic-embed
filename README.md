# Embed

> Embed is a Statamic addon that allows you to embed content from across the web: videos, tweets, photos, and anything else supported by oEmbed.

Embed masks away the complexity for authors to find the embeddable markup to include external content on your site, and empowers developers to provide performant rich content experiences without needing to handle author-inputted HTML.

- **Instant preview** so authors know they’re using the right link
- **Multi-site support** for localizing embeds
- **Flexible templating options** for both [Antlers](#antlers) and [Blade](#blade)

## Get Started

- [Installation](#installation)
- [Templating](#templating)
    - [Antlers](#antlers)
    - [Blade](#blade)
    - [Available data](#available-data)
- [Configuration](#configuration)
    - [Cache](#cache)
    - [Underlying Library Configuration](#underlying-library-configuration)
- [Schema](#schema)
- [Licensing](#licensing)

## Installation

You can find and install Embed from the Statamic control panel under _Tools → Addons_, or install from your project root using [Composer](https://getcomposer.org).

``` bash
composer require bencarr/statamic-embed
```

## Templating

Embed works great with both Antlers and Blade, and has built-in conveniences to give you full control over your template markup.

### Antlers

// TODO

### Blade

// TODO

### Available data

The field value of an Embed field is an `EmbedData` object, which works just like an array in your templates. Inside you’ve got access to everything you’ll need to completely customize your presentation:

| Property | Type     | Value                               |
|----------|----------|-------------------------------------|
| `url`    | `string` | The original URL to the destination |


## Configuration

Customize Embed’s behavior by publishing the `embed-config` tag.

```bash
php artisan vendor:publish --tag=embed-config
```

You can find the published configuration in `config/statamic/embed.php`.

### Cache

Embed uses Laravel’s default cache driver by default, but this can be customized using the `cache.driver` setting, or by setting the `EMBED_CACHE_DRIVER` environment variable. By default, Embed data is cached forever (with the option to manually refresh from the control panel). You can shorten the TTL using the `cache.ttl` setting, or by setting the `EMBED_CACHE_TTL` environment variable.

```php
return [
    'cache' => [
        'driver' => 'redis',
        'ttl' => 60 * 60 * 24 * 365, // 1 Year
    ]
];
```

### Underlying Library Configuration

Embed uses the excellent [Embed](https://github.com/oscarotero/Embed) library by Oscar Otero under the hood, which offers a lot of flexibility to customize your application’s interaction with providers.

#### HTTP Client

You can swap out or configure the underlying HTTP client by adjusting `client.class` and `client.settings`. More information about what clients are supported is available in the [library documentation](https://github.com/oscarotero/Embed).

```php
return [
    'client' => [
        'class' => GuzzleHttp\Client::class,
        'settings' => [
            'timeout' => 2,
        ],
    ]
];
```

#### Detector Settings

Some providers may require an authentication token or accept additional settings to customize their responses. You can provide these settings using the `settings` config.

```php
return [
    'settings' => [
        'twitch:parent' => 'example.com',
        'instagram:token' => '1234|5678',    
    ],
];
```

#### Custom Adapters & Detectors

You can access the raw `Embed\Embed` instance to add custom adapters and detectors by resolving it through Laravel’s container. More information on custom adapters and detectors is available in the [library’s documentation](https://github.com/oscarotero/Embed).

```php
// YourServiceProvider.php
app(Embed\Embed::class)
    ->getExtractorFactory()
    ->setDefault(YourCustomExtractor::class) // Set the default extractor
    ->addAdapter('example.com', YourCustomAdapter::class) // Add an adapter
    ->removeAdapter('instagram.com') // Remove a built-in adapter
    ->addDetector('robots', YourRobotsDetector::class); // Add a detector
```

## Schema

Embed data is stored in a small object with the provided `url` and whether the CP `preview` is enabled. All other data lives in Laravel’s cache (customizable in your [configuration](#configuration)) and can be refreshed on-demand.

```yaml
---
title: My Entry
embed: 
  url: https://www.youtube.com/watch?v=dQw4w9WgXcQ
  preview: true
---
```

## Licensing

Embed is a Commercial Addon.

You can use it for free while in development, but requires a license to use on a live site. Learn more or buy a license on [The Statamic Marketplace](https://statamic.com/addons/bencarr/embed)!

