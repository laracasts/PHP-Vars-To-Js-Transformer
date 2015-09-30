<?php

namespace Laracasts\Utilities\JavaScript;

use Illuminate\Contracts\Events\Dispatcher;

class LaravelViewBinder implements ViewBinder
{
    /**
     * The event dispatcher implementation.
     *
     * @var Dispatcher
     */
    private $event;

    /**
     * The name of the view to bind JS variables to.
     *
     * @var string
     */
    private $views;

    /**
     * Create a new Laravel view binder instance.
     *
     * @param Dispatcher   $event
     * @param string|array $views
     */
    function __construct(Dispatcher $event, $views)
    {
        $this->event = $event;
        $this->views = str_replace('/', '.', (array)$views);
    }

    /**
     * Bind the given JavaScript to the view.
     *
     * @param string $js
     */
    public function bind($js)
    {
        foreach ($this->views as $view) {
            $this->event->listen("composing: {$view}", function () use ($js) {
                echo "<script>{$js}</script>";
            });
        }
    }
}
