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
        return $this->buildNgConstant($vars);
    }

    /**
     * Translate PHP vars array to an Angular constant.
     *
     * @param  array $vars
     * @return string
     */
    protected function buildNgConstant($vars)
    {
        $js = "angular.module('{$this->module}')";
        $js .= ".constant('{$this->constant}', {$this->transformArray($vars)});";

        return $js;
    }

} 
