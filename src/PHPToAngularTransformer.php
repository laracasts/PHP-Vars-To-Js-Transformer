<?php

namespace Laracasts\Utilities\JavaScript;

class PHPToAngularTransformer extends PHPToJavaScriptTransformer
{

    /**
     * The module to nest the constants under.
     *
     * @var string
     */
    protected $module;

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
     * @param string     $module
     */
    function __construct(ViewBinder $viewBinder, $module = 'app')
    {
        $this->viewBinder = $viewBinder;
        $this->module = $module;
    }

    /**
     * Translate the array of PHP vars to
     * the expected JavaScript syntax.
     *
     * @param  array $vars
     * @return array
     */
    public function buildJavaScriptSyntax(array $vars)
    {
        $js = $this->buildModule();

        foreach ($vars as $key => $value) {
            $js .= $this->buildConstant($key, $value);
        }

        return $js;
    }

    /**
     * Create the module that all
     * constants will be nested under.
     *
     * @return string
     */
    protected function buildModule()
    {
        return "angular.module('{$this->module}')";
    }

    /**
     * Translate a single PHP var to an Angular constant.
     *
     * @param  string $key
     * @param  string $value
     * @return string
     */
    protected function buildConstant($key, $value)
    {
        return ".constant('{$key}', {$this->optimizeValueForJavaScript($value)});";
    }

} 
