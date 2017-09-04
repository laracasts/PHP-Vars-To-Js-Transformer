<?php

namespace Laracasts\Utilities\JavaScript\Transformers;

use JsonSerializable;
use stdClass;

class ObjectTransformer
{
    /**
     * Transform an object to JS.
     *
     * @param  object $value
     * @return string
     * @throws \Exception
     */
    public function transform($value)
    {
        if ($value instanceof JsonSerializable || $value instanceof StdClass) {
            return json_encode($value);
        }

        // If a toJson() method exists, the object can cast itself automatically.
        if (method_exists($value, 'toJson')) {
            return $value;
        }

        // Otherwise, if the object doesn't even have a __toString() method, we can't proceed.
        if (! method_exists($value, '__toString')) {
            throw new \Exception('Cannot transform this object to JavaScript.');
        }

        return "'{$value}'";
    }
}
