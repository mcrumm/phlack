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
    public function __construct(Encodable $message = null)
    {
        if ($message) {
            $this->setMessage($message);
        }
    }

    /**
     * @param Encodable $message
     * @return $this
     */
    public function setMessage(Encodable $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return (string)$this->message;
    }

    /**
     * @param string $id
     * @param string $name
     * @return string
     */
    protected function format($id, $name)
    {
        return sprintf('[%s|%s]', $id, $name);
    }
}
