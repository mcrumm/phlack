<?php

namespace Crummy\Phlack\Common\Collection;

use Crummy\Phlack\Common\Exception\ElementNotAcceptedException;
use Doctrine\Common\Collections\ArrayCollection;

abstract class ScrutinizingCollection extends ArrayCollection
{
    /**
     * {@inheritDoc}
     * @throws ElementNotAcceptedException
     */
    public function __construct(array $elements = array())
    {
        foreach ($elements as $element) {
            if (!$this->acceptsElement($element)) {
                throw new ElementNotAcceptedException();
            }
        }

        parent::__construct($elements);
    }

    /**
     * {@inheritDoc}
     * @throws ElementNotAcceptedException
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
     * @throws ElementNotAcceptedException
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
 