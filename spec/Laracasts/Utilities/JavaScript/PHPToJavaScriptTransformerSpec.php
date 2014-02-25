<?php

namespace spec\Laracasts\Utilities\JavaScript;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Laracasts\Utilities\JavaScript\ViewBinder;

class PHPToJavaScriptTransformerSpec extends ObjectBehavior
{

    function let(ViewBinder $viewBinder)
    {
        $this->beConstructedWith($viewBinder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Laracasts\Utilities\JavaScript\PHPToJavaScriptTransformer');
    }

    function it_nests_all_vars_under_namespace()
    {
        // defaulting to window
        $this->buildJavaScriptSyntax([])
            ->shouldMatch('/window.window = window.window || {};/');
    }

    function it_transforms_php_strings()
    {
        $this->buildJavaScriptSyntax(['foo' => 'bar'])
             ->shouldMatch("/window.foo = 'bar';/");
    }

    function it_transforms_php_arrays()
    {
        $this->buildJavaScriptSyntax(['letters' => ['a', 'b']])
             ->shouldMatch('/window.letters = \["a","b"\];/');
    }

    function it_transforms_php_booleans()
    {
        $this->buildJavaScriptSyntax(['isFoo' => false])
            ->shouldMatch('/window.isFoo = false;/');
    }

    function it_transforms_numerics()
    {
        $this->buildJavaScriptSyntax(['age' => 10, 'sum' => 10.12, 'dec' => 0.5])
            ->shouldMatch('/window.age = 10;window.sum = 10.12;window.dec = 0.5;/');
    }

    function it_throws_an_exception_if_an_object_cant_be_transformed(\StdClass $obj)
    {
        $this->shouldThrow('Exception')
            ->duringBuildJavaScriptSyntax(['foo' => $obj]);
    }
}
