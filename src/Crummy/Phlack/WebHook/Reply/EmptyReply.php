<?php

namespace Crummy\Phlack\WebHook\Reply;

class EmptyReply extends Reply
{
    protected $defaults = [ 'text' => '' ];

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct($this->defaults);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value)
    {
        // no-op
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return $this->defaults;
    }
}
