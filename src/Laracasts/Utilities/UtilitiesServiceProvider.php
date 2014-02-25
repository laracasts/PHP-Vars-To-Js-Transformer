<?php namespace Laracasts\Utilities;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Laracasts\Utilities\JavaScript\PHPToJavaScriptTransformer;
use Laracasts\Utilities\JavaScript\LaravelViewBinder;
use Config;

class UtilitiesServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Give', function($app) {
            $view = Config::get('utilities::config.bind_js_vars_to_this_view');
            $namespace = Config::get('utilities::config.js_namespace');

            $binder = new LaravelViewBinder($app['events'], $view);

            return new PHPToJavaScriptTransformer($binder, $namespace);
        });
    }

    public function boot()
    {
        $this->package('laracasts/utilities');

        // Give::javaScript(['foo' => 'bar'])
        AliasLoader::getInstance()->alias(
            'Give',
            'Laracasts\Utilities\JavaScript\Facades\Give'
        );
    }


    /**
     * The service provided
     *
     * @return array
     */
    public function provides()
    {
        return ['Give'];
    }

}