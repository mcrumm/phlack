<?php

namespace Crummy\Phlack\WebHook\Reply;

class EmptyReply extends Reply
{
    protected $defaults = ['text' => ''];

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct($this->defaults);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        // no-op
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->defaults;
    }
}
