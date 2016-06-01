<?php

namespace Crummy\Phlack\Message;

use Crummy\Phlack\Common\Hash;

abstract class Partial extends Hash
{
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return array_filter($this->toArray(), function ($value) {
            if ($value instanceof \Countable) {
                return 0 < $value->count();
            }

            return false === $value || !empty($value);
        });
    }
}
