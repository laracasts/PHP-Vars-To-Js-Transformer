<?php

namespace Laracasts\Utilities\JavaScript\Transformers;

class BooleanTransformer
{
    /**
     * Transform a boolean.
     *
     * @param  boolean $value
     * @return string
     */
    public function transform($value)
    {
        return $value ? 'true' : 'false';
    }
}