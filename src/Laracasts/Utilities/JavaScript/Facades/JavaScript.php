<?php namespace Laracasts\Utilities\JavaScript\Facades;

use Illuminate\Support\Facades\Facade;

class JavaScript extends Facade {

    /**
     * Name of the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'JavaScript';
    }

} 