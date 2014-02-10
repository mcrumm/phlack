<?php

namespace Crummy\Phlack\Common\Collection;

use Crummy\Phlack\Common\Exception\UnexpectedValueException;

abstract class TypeCollection extends ArrayCollection
{
    /**
     * {@inheritDoc}
     * @throws UnexpectedValueException
     */
    public function __construct(array $elements = [ ])
    {
        foreach ($elements as $element) {
            if (!$this->acceptsType($element)) {
                throw new UnexpectedValueException(sprintf(
                    '"%s" does not match the expected type.',
                    is_object($element) ? get_class($element) : gettype($element)
                ));
            }
        }

        parent::__construct($elements);
    }

    /**
     * {@inheritDoc}
     * @throws UnexpectedValueException
     */
    public function add($value)
    {
        if (!$this->acceptsType($value)) {
            throw new UnexpectedValueException();
        }

        return parent::add($value);
    }

    /**
     * {@inheritDoc}
     * @throws UnexpectedValueException
     */
    public function set($key, $value)
    {
        if (!$this->acceptsType($value)) {
            throw new UnexpectedValueException();
        }

        parent::set($key, $value);
    }

    /**
     * @param $value
     * @return boolean
     */
    abstract public function acceptsType($value);
}
 