<?php

namespace Laracasts\Utilities\JavaScript;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Laracasts\Utilities\JavaScript\PHPToJavaScriptTransformer;
use Laracasts\Utilities\JavaScript\LaravelViewBinder;

class JavaScriptServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('JavaScript', function ($app) {
            $view = config('javascript.bind_js_vars_to_this_view');
            $namespace = config('javascript.js_namespace');

            if (is_null($view)) {
                throw new JavaScriptException;
            }

            $binder = new LaravelViewBinder($app['events'], $view);

            return new PHPToJavaScriptTransformer($binder, $namespace);
        });

        if(config('javascript.ng_module')) {
            $this->app->bind('Angular', function ($app) {
                $view = config('javascript.bind_js_vars_to_this_view');
                $module = config('javascript.ng_module');

                if (is_null($view)) {
                    throw new JavaScriptException;
                }

                $binder = new LaravelViewBinder($app['events'], $view);

                return new PHPToAngularTransformer($binder, $module);
            });
        }
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

        if(config('javascript.ng_module')) {
            AliasLoader::getInstance()->alias(
                'Angular',
                'Laracasts\Utilities\JavaScript\AngularFacade'
            );
        }
    }

}
