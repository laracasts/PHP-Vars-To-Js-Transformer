<?php

if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param string $path
     * @return string
     */
    function config_path($path = '')
    {
        $basePath = app()->basePath();
        $adjustedPath = $path ? "/$path" : $path;

        return "$basePath/config$adjustedPath";
    }
}
