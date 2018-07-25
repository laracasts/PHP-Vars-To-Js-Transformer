<?php

namespace Laracasts\Utilities\JavaScript;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string put(mixed $args, mixed $value = null);
 * @method static string constructJavaScript(array $variables);
 *
 * @see \Laracasts\Utilities\JavaScript\Transformers\Transformer
 */
class JavaScriptFacade extends Facade
{
    /**
     * The name of the binding in the IoC container.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'JavaScript';
    }
}
