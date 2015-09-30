<?php

namespace Laracasts\Utilities\JavaScript;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class JavaScriptServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('JavaScript', function ($app) {
            $view = config('javascript.bind_js_vars_to_this_view');
            $namespace = config('javascript.js_namespace');

            $binder = new LaravelViewBinder($app['events'], $view);

            return new PHPToJavaScriptTransformer($binder, $namespace);
        });

        $this->mergeConfigFrom(
            __DIR__ . '/config/javascript.php', 'javascript'
        );
    }

    /**
     * Publish the plugin configuration.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/javascript.php' => config_path('javascript.php')
        ]);

        AliasLoader::getInstance()->alias(
            'JavaScript',
            'Laracasts\Utilities\JavaScript\JavaScriptFacade'
        );
    }

}
