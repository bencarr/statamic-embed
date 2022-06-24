<?php

namespace BenCarr\Embed;

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
    }

    public function register()
    {
        parent::register();

        $this->mergeConfigFrom(__DIR__.'/../config/statamic/embed.php', 'statamic.embed');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'embed');
    }
}
