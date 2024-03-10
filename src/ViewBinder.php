<?php

namespace Laracasts\Utilities\JavaScript;

interface ViewBinder
{
    /**
     * Bind the JavaScript variables to the view.
     *
     * @param string $js
     */
    public function bind($js);


    /**
     * Set the array of HTML attributes for the <script> tag(s)
     *
     * @param array $htmlAttributes associative array of HTML element attributes
     */
    public function setHtmlAttributes(array $htmlAttributes);
}
