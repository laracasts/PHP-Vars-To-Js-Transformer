<?php

namespace Laracasts\Utilities\JavaScript;

use Illuminate\Events\Dispatcher;

class LaravelViewBinder implements ViewBinder
{

    /**
     * The event dispatcher implementation.
     *
     * @var Dispatcher
     */
    private $event;

    /**
     * The name of the view to bind any
     * generated JS variables to.
     * 
     * @var string
     */
    private $viewToBindVariables;

    /**
     * Create a new Laravel view binder instance.
     *
     * @param Dispatcher $event
     * @param string     $viewToBindVariables
     */
    function __construct(Dispatcher $event, $viewToBindVariables)
    {
        $this->event = $event;
        $this->viewToBindVariables = str_replace('/', '.', $viewToBindVariables);
    }

    /**
     * Bind the given JavaScript to the view.
     *
     * @param string $js
     */
    public function bind($js)
    {
        $views = (array) $this->viewToBindVariables;

        foreach ($views as $view)
        {
            $this->event->listen("composing: {$view}", function() use ($js) {
                echo "<script>{$js}</script>";
            });
        }
    }

}
