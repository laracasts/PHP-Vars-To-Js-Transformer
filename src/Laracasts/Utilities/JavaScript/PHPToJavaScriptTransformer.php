<?php namespace Laracasts\Utilities\JavaScript;

use Exception;

class PHPToJavaScriptTransformer {

    /**
     * Namespace to nest JS vars under
     *
     * @var string
     */
    private $namespace;

    /**
     * @var ViewBinder
     */
    private $viewBinder;

    /**
     * @param ViewBinder $viewBinder
     * @param string $namespace
     */
    function __construct(ViewBinder $viewBinder, $namespace = 'window')
    {
        $this->viewBinder = $viewBinder;
        $this->namespace = $namespace;
    }

    /**
     * Bind given array of variables to view
     *
     * @param array $vars
     */
    public function javaScript(array $vars)
    {
        // First, though, we have to translate the
        // variables to something JS-friendly.
        $js = $this->buildJavaScriptSyntax($vars);

        // This is what handles the process of binding
        // our JS vars to the view/page.
        $this->viewBinder->bind($js);
    }

    /**
     * Translate the array of PHP vars
     * to JavaScript syntax.
     *
     * @param array $vars
     * @internal param $js
     *
     * @return array
     */
    protected function buildJavaScriptSyntax(array $vars)
    {
        $js = $this->buildNamespaceDeclaration();

        foreach ($vars as $key => $value) {
            $js .= $this->buildVariableDeclaration($key, $value);
        }

        return $js;
    }

    /**
     * Create the namespace that all
     * vars will be nested under.
     *
     * @return string
     */
    protected function buildNamespaceDeclaration()
    {
        return "window.{$this->namespace} = window.{$this->namespace} || {};";
    }

    /**
     * Translate a single PHP var to JS
     *
     * @param $key
     * @param $value
     *
     * @return string
     */
    protected function buildVariableDeclaration($key, $value)
    {
        return "{$this->namespace}.{$key} = {$this->optimizeValueForJavaScript($value)};";
    }

    /**
     * Format a value for JavaScript
     *
     * @param $value
     *
     * @throws \Exception
     * @return bool|float|string
     */
    protected function optimizeValueForJavaScript($value)
    {
        if (is_array($value))
        {
            return json_encode($value);
        }

        if (is_bool($value))
        {
            return $value ? 'true' : 'false';
        }

        if (is_numeric($value))
        {
            return $value;
        }

        if (is_object($value))
        {
            // If a toJson method exists, we'll assume that
            // the object can cast itself automatically
            if (method_exists($value, 'toJson')) return $value;

            // Otherwise, if the object doesn't even have
            // a toString method, we can't proceed.
            if ( ! method_exists($value, '__toString'))
            {
                throw new Exception('The provided object needs a __toString() method.');
            }

            return "'{$value}'";
        }

        return "'{$this->escape($value)}'";
    }

    /**
     * Escape single quotes (for now).
     * What else do we need to worry about?
     *
     * @param $value
     *
     * @return mixed
     */
    protected function escape($value)
    {
        return str_replace("'", "\\'", $value);
    }

} 