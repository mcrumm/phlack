<?php

namespace Crummy\Phlack\WebHook\Reply;

class EmptyReply extends Reply
{
    /**
     * @param array $data
     */
    public function __construct($data = [])
    {
        parent::__construct($this->getDefaults());
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaults()
    {
        return [ 'text' => '' ];
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value)
    {
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return $this->getDefaults();
    }
}
