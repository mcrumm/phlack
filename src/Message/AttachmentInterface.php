<?php

namespace Crummy\Phlack\Message;

use Crummy\Phlack\Common\Encodable;

interface AttachmentInterface extends Encodable
{
    /**
     * @param FieldInterface $field
     *
     * @return self
     */
    public function addField(FieldInterface $field);

    /**
     * @return Collection\FieldCollection
     */
    public function getFields();
}
