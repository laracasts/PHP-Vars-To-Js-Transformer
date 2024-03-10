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
    protected $event;

    /**
     * The name of the view to bind JS variables to.
     *
     * @var string
     */
    protected $views;

    /**
     * Create a new Laravel view binder instance.
     *
     * @param Dispatcher   $event
     * @param string|array $views
     */
    public function __construct(Dispatcher $event, $views)
    {
        $this->event = $event;
        $this->views = str_replace('/', '.', (array)$views);
    }

    /**
     * Bind the given JavaScript to the view.
     * Tracks if Javascript has already been added
     * by keeping hashes of the js code to check against in the view data
     *
     * @param string $js
     */
    public function bind($js)
    {
        foreach ($this->views as $view) {
            $this->event->listen("composing: {$view}", function ($view) use ($js) {
                $data = $view->getData();
                $hashes = isset($data['hashes']) ? $data['hashes'] : [];
                $hash = md5($js);
                if (!in_array($hash,$hashes)) {
                    $hashes[] = md5($js);
                    $view->with('hashes',$hashes);
                    echo "<script>{$js}</script>";
                }
            });
        }
    }
}
