<?php

namespace Crummy\Phlack\Message\Collection;

use Crummy\Phlack\Message\AttachmentInterface;

class AttachmentCollection extends EncodableCollection
{
    /**
     * @param $value
     * @return boolean
     */
    public function acceptsType($value)
    {
        return $value instanceof AttachmentInterface;
    }
}
