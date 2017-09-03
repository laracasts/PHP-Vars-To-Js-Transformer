<?php

namespace Laracasts\Utilities\JavaScript\Transformers;

class ArrayTransformer
{
    /**
     * Transform an array.
     *
     * @param  array $value
     * @return string
     */
    public function transform($value)
    {
        return json_encode($value);
    }
}