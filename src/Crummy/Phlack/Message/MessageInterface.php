<?php

namespace Crummy\Phlack\Message;

use Crummy\Phlack\Common\Encodable;

interface MessageInterface extends Encodable
{
    /**
     * @param AttachmentInterface $attachment
     *
     * @return self
     */
    public function addAttachment(AttachmentInterface $attachment);

    /**
     * @return Collection\AttachmentCollection
     */
    public function getAttachments();
}
