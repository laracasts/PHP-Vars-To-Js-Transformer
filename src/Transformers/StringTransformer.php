<?php

namespace Laracasts\Utilities\JavaScript\Transformers;

class StringTransformer
{
    /**
     * Transform a string.
     *
     * @param  string $value
     * @return string
     */
    public function transform($value)
    {
        if (is_string($value)) {
            return "'{$this->escape($value)}'";
        }
    }

    /**
     * Escape any single quotes.
     *
     * @param  string $value
     * @return string
     */
    protected function escape($value)
    {
        return str_replace(["\\", "'", "\n"], ["\\\\", "\'", "\\n"], $value);
    }
}