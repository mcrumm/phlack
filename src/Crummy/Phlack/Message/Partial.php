<?php

namespace Crummy\Phlack\Message;

use Crummy\Phlack\Common\Encodable;

abstract class Partial implements Encodable
{
    protected $data = [];

    /**
     * Sets values on non-empty parameters.
     * Set $value to null to remove the custom value.
     * @param $name
     * @param $value
     * @return $this
     */
    protected function set($name, $value)
    {
        if (null !== $value && false !== $value && empty($value)) { return $this; }

        $this->data[$name] = $value;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return array_filter($this->data, function($value) {
            return (false === $value || !empty($value));
        });
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }
}
