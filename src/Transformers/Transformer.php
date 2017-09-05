<?php

namespace Laracasts\Utilities\JavaScript\Transformers;

use Exception;
use Laracasts\Utilities\JavaScript\ViewBinder;

class Transformer
{
    /**
     * The namespace to nest JS variables under.
     *
     * @var string
     */
    protected $namespace;

    /**
     * What binds the variables to the views.
     *
     * @var ViewBinder
     */
    protected $viewBinder;

    /**
     * Create a new JS transformer instance.
     *
     * @param ViewBinder $viewBinder
     * @param string     $namespace
     */
    public function __construct(ViewBinder $viewBinder, $namespace = 'window')
    {
        $this->viewBinder = $viewBinder;
        $this->namespace = $namespace;
    }

    /**
     * Bind the given array of variables to the view.
     */
    public function put()
    {
        $js = $this->constructJavaScript($this->normalizeInput(func_get_args()));

        $this->viewBinder->bind($js);

        return $js;
    }

    /**
     * Translate the array of PHP variables to a JavaScript syntax.
     *
     * @param  array $variables
     * @return array
     */
    public function constructJavaScript($variables)
    {
        return $this->constructNamespace() . collect($variables)->map(function ($value, $name) {
            return $this->initializeVariable($name, $value);
        })->implode('');
    }

    /**
     * Create the namespace to which all vars are nested.
     *
     * @return string
     */
    protected function constructNamespace()
    {
        if ($this->namespace == 'window') {
            return '';
        }

        return "window.{$this->namespace} = window.{$this->namespace} || {};";
    }

    /**
     * Translate a single PHP var to JS.
     *
     * @param  string $key
     * @param  string $value
     * @return string
     */
    protected function initializeVariable($key, $value)
    {
        return "{$this->namespace}.{$key} = {$this->convertToJavaScript($value)};";
    }

    /**
     * Format a value for JavaScript.
     *
     * @param  string $value
     * @throws Exception
     * @return string
     */
    protected function convertToJavaScript($value)
    {
        $transformer = is_object($value) ? ObjectTransformer::class : DefaultTransformer::class;

        return (new $transformer)->transform($value);
    }

    /**
     * Normalize the input arguments.
     *
     * @param  mixed $arguments
     * @return array
     * @throws \Exception
     */
    protected function normalizeInput($arguments)
    {
        if (is_array($arguments[0])) {
            return $arguments[0];
        }

        if (count($arguments) == 2) {
            return [$arguments[0] => $arguments[1]];
        }

        throw new Exception('Try JavaScript::put(["foo" => "bar"])');
    }
}
