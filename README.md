# Embed

> Embed is a Statamic addon that allows you to embed content from across the web: videos, tweets, photos, and anything else supported by oEmbed.

Embed masks away the complexity for authors to find the embeddable markup to include external content on your site, and empowers developers to provide performant rich content experiences without needing to handle author-inputted HTML.

- **Link to everything** including entries, URLs, email addresses, assets, taxonomy terms, and phone numbers
- **Multi-site support** for localizing links
- **Flexible templating options** for both [Antlers](#antlers) and [Blade](#blade)

## Get Started

- [Installation](#installation)
- [Templating](#templating)
    - [Antlers](#antlers)
    - [Blade](#blade)
    - [Available data](#available-data)
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


## Schema

Embed data is stored simply as the provided URL. All other data lives in Statamic’s cache and can be refreshed on-demand.

```yaml
---
title: My Entry
embed: https://www.youtube.com/watch?v=dQw4w9WgXcQ
---
```

## Licensing

Embed is a Commercial Addon.

You can use it for free while in development, but requires a license to use on a live site. Learn more or buy a license on [The Statamic Marketplace](https://statamic.com/addons/bencarr/embed)!

