<?php namespace Laracasts\Utilities\JavaScript;

interface ViewBinder {

    /**
     * Bind the JavaScript to the view
     *
     * @param $js
     */
    public function bind($js);

} 