<?php namespace Laracasts\Utilities\JavaScript;

use Illuminate\Events\Dispatcher;

class LaravelViewBinder implements ViewBinder {

    /**
     * @var Dispatcher
     */
    private $event;

    /**
     * @var string
     */
    private $viewToBindVariables;

    /**
     * @param Dispatcher $event
     * @param $viewToBindVariables
     */
    function __construct(Dispatcher $event, $viewToBindVariables)
    {
        $this->event = $event;
        $this->viewToBindVariables = $viewToBindVariables;
    }

    /**
     * Bind the given JavaScript to the
     * view using Laravel event listeners
     *
     * @param $js The ready-to-go JS
     */
    public function bind($js)
    {
        if ( ! is_array($this->viewToBindVariables))
        {
            $this->viewToBindVariables = [$this->viewToBindVariables];
        }

        foreach ($this->viewToBindVariables as $viewVariable)
        {
            $this->event->listen("composing: {$viewVariable}", function () use ($js)
            {
                echo "<script>{$js}</script>";
            });
        }

    }
    
}