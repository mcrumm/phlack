<?php

namespace Crummy\Phlack\Common\Formatter;

use Crummy\Phlack\Common\Encodable;

abstract class AbstractFormatter implements Encodable
{
    /** @var \Crummy\Phlack\Common\Encodable */
    protected $message;

    /**
     * @param Encodable $message
     */
    public function __construct(Encodable $message)
    {
        $this->message = $message;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return (string)$this->message;
    }
}
