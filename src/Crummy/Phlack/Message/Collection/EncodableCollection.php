<?php

namespace Crummy\Phlack\Message\Collection;

use Crummy\Phlack\Common\Encodable;
use Crummy\Phlack\Exception\ElementNotAcceptedException;
use Doctrine\Common\Collections\ArrayCollection;

abstract class EncodableCollection extends ArrayCollection implements Encodable
{
    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return array_filter($this->toArray());
    }

    /**
     * {@inheritDoc}
     * @throws \Crummy\Phlack\Exception\ElementNotAcceptedException
     */
    public function add($value)
    {
        if (!$this->acceptsElement($value)) {
            throw new ElementNotAcceptedException();
        }

        return parent::add($value);
    }

    /**
     * {@inheritDoc}
     * @throws \Crummy\Phlack\Exception\ElementNotAcceptedException
     */
    public function set($key, $value)
    {
        if (!$this->acceptsElement($value)) {
            throw new ElementNotAcceptedException();
        }

        parent::set($key, $value);
    }

    /**
     * @param $value
     * @return boolean
     */
    abstract public function acceptsElement($value);
}
