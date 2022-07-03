<?php

namespace BenCarr\Embed;

use Embed\Embed;
use Embed\Http\Crawler;
use GuzzleHttp\Client;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $viewNamespace = 'embed';

    protected $fieldtypes = [
        Fieldtypes\Embed::class,
    ];

    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
    ];

    protected $scripts = [
        __DIR__.'/../dist/js/addon.js',
    ];

    public function bootAddon()
    {
        $this->publishes([
            __DIR__.'/../config/statamic/embed.php' => config_path('statamic/embed.php'),
        ], 'embed-config');

        $this->publishes([
            __DIR__.'/../dist/css/preview.css' => public_path("vendor/statamic-embed/css/preview.css"),
        ], 'embed');
    }

    public function register()
    {
        parent::register();

        $this->mergeConfigFrom(__DIR__.'/../config/statamic/embed.php', 'statamic.embed');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'embed');

        $this->app->singleton(Embed::class, function ($app) {
            $config = collect($app['config']['statamic']['embed']);
            $client = new Client($config->get('client_settings', []));
            $embed = (new Embed(new Crawler($client)));
            $embed->setSettings($config->get('settings', []));

            return $embed;
        });
    }
}
