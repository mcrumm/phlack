<?php

namespace Crummy\Phlack\Message\Collection;

use Crummy\Phlack\Message\FieldInterface;

class FieldCollection extends EncodableCollection
{
    /**
     * @param $value
     * @return boolean
     */
    public function acceptsType($value)
    {
        return $value instanceof FieldInterface;
    }
}
