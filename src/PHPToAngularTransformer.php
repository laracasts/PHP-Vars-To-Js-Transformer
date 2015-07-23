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
     * The name of the constant.
     *
     * @var string
     */
    private $constant;

    /**
     * Create a new Angular transformer instance.
     *
     * @param ViewBinder $viewBinder
     * @param string     $module
     * @param string     $constant
     */
    function __construct(ViewBinder $viewBinder, $module = 'app', $constant = 'DATA')
    {
        $this->viewBinder = $viewBinder;
        $this->module = $module;
        $this->constant = $constant;
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
        $js .= $this->buildConstant($vars);
        $js .= ';';

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
     * @param  array $vars
     * @return string
     */
    protected function buildConstant($vars)
    {
        return ".constant('{$this->constant}', {$this->optimizeValueForJavaScript($vars)});";
    }

} 
