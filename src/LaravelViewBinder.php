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
     * An array of HTML attributes to add to the <script> tag(s)
     *
     * @var array
     */
    protected $htmlAttributes;

    /**
     * Create a new Laravel view binder instance.
     *
     * @param Dispatcher   $event
     * @param string|array $views
     * @param array        $attributes
     */
    public function __construct(Dispatcher $event, $views, $htmlAttributes = [])
    {
        $this->event          = $event;
        $this->views          = str_replace('/', '.', (array)$views);
        $this->htmlAttributes = $htmlAttributes;
    }

    /**
     * Set the array of HTML attributes
     *
     * @param array $htmlAttributes
     */
    public function setHtmlAttributes(array $htmlAttributes)
    {
        $this->htmlAttributes = $htmlAttributes;
    }

    /**
     * Get the list of HTML attributes, as an array or an HTML-ready string
     *
     * @param boolean $toString should we return the attributes as a string?
     * @return array|string
     */
    protected function getHtmlAttributes($toString = false)
    {
        if ($toString === false) {
          return $this->htmlAttributes;
        }

        $out = "";
        foreach ($this->htmlAttributes as $attribute => $value) {
            $out .= " {$attribute}=\"{$value}\"";
        }
        return $out;
    }

    /**
     * Bind the given JavaScript to the view.
     *
     * @param string $js
     */
    public function bind($js)
    {
        $htmlAttributes = $this->getHtmlAttributes(true);
        foreach ($this->views as $view) {
            $this->event->listen("composing: {$view}", function () use ($htmlAttributes, $js) {
                echo "<script{$htmlAttributes}>{$js}</script>";
            });
        }
    }
}
