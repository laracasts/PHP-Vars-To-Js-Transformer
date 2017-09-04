<?php

namespace spec\Laracasts\Utilities\JavaScript\Transformers;

use Laracasts\Utilities\JavaScript\Transformers\Transformer;
use Laracasts\Utilities\JavaScript\ViewBinder;
use PhpSpec\ObjectBehavior;

class TransformerSpec extends ObjectBehavior
{
    public function let(ViewBinder $viewBinder)
    {
        $this->beConstructedWith($viewBinder);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Laracasts\Utilities\JavaScript\Transformers\Transformer');
    }

    public function it_binds_to_the_view(ViewBinder $viewBinder)
    {
        $viewBinder->bind('window.foo = "bar";')->shouldBeCalled();

        $this->put(['foo' => 'bar'])->shouldReturn('window.foo = "bar";');
    }

    public function it_uses_the_window_as_the_root_namespace_by_default()
    {
        $this->constructJavaScript([])
            ->shouldEqual('');
    }

    public function if_another_namespace_is_provided_it_will_use_that_instead(ViewBinder $viewBinder)
    {
        $this->beConstructedWith($viewBinder, 'Namespace');

        $this->constructJavaScript([])
            ->shouldEqual('window.Namespace = window.Namespace || {};');
    }

    public function it_translates_an_array_of_key_value_pairs_to_javascript()
    {
        $this->put(['foo' => 'bar'])
            ->shouldMatch("/window.foo = \"bar\";/");
    }

    public function it_translates_two_arguments_as_key_and_value_to_javascript()
    {
        $this->put('foo', 'bar')
            ->shouldMatch("/window.foo = \"bar\";/");
    }

    public function it_takes_exception_if_incorrect_arguments_are_passed_to_put()
    {
        $this->shouldThrow('Exception')->duringPut();
    }

    public function it_transforms_php_strings()
    {
        $this->constructJavaScript(['foo' => 'bar'])
            ->shouldMatch("/window.foo = \"bar\";/");
    }

    public function it_transforms_multiline_php_strings()
    {
        $this->constructJavaScript(['foo' => "new\nline"])
            ->shouldContain('\n'); // String
        $this->constructJavaScript(['foo' => "new\nline"])
            ->shouldNotContain("\n"); // Newline character
    }

    public function it_transforms_php_arrays()
    {
        $this->constructJavaScript(['letters' => ['a', 'b']])
            ->shouldMatch('/window.letters = \["a","b"\];/');
    }

    public function it_transforms_multiline_strings_in_php_arrays()
    {
        $this->constructJavaScript(['newline' => ["new\nline"]])
            ->shouldContain('\n'); // String
        $this->constructJavaScript(['newline' => ["new\nline"]])
            ->shouldNotContain("\n"); // Newline character
    }

    public function it_transforms_php_booleans()
    {
        $this->constructJavaScript(['isFoo' => false])
            ->shouldMatch('/window.isFoo = false;/');
    }

    public function it_transforms_numerics()
    {
        $this->constructJavaScript(['age' => 10, 'sum' => 10.12, 'dec' => 0])
            ->shouldMatch('/window.age = 10;window.sum = 10.12;window.dec = 0;/');
    }

    public function it_transforms_null_values()
    {
        $this->constructJavaScript(['age' => null, 'sum' => null])
            ->shouldMatch('/window.age = null;window.sum = null;/');
    }

    public function it_transforms_json_serializable_objects()
    {
        $this->constructJavaScript(['foo' => new JsonSerializableClass])
            ->shouldMatch('/window.foo = {"key":"value"}/');
    }

    public function it_throws_an_exception_if_an_object_cant_be_transformed(Transformer $obj)
    {
        $this->shouldThrow('Exception')
            ->duringConstructJavaScript(['foo' => $obj]);
    }

    public function it_does_not_throw_an_exception_for_stdClass(\StdClass $obj)
    {
        $this->constructJavaScript(['foo' => $obj])
            ->shouldMatch('/window.window = window.window || {};/');
    }
}

class JsonSerializableClass implements \JsonSerializable
{
    public function jsonSerialize()
    {
        return ['key' => 'value'];
    }
}
