<?php

namespace Crummy\Phlack\Common\Collection;

use Crummy\Phlack\Common\Exception\UnexpectedValueException;

abstract class TypeCollection extends ArrayCollection
{
    /**
     * {@inheritdoc}
     *
     * @throws UnexpectedValueException
     */
    public function __construct(array $elements = [])
    {
        parent::__construct();

        foreach ($elements as $element) {
            $this->add($element);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws UnexpectedValueException
     */
    public function add($value)
    {
        if (!$this->acceptsType($value)) {
            throw $this->doUnexpectedValueError($value);
        }

        return parent::add($value);
    }

    /**
     * {@inheritdoc}
     *
     * @throws UnexpectedValueException
     */
    public function set($key, $value)
    {
        if (!$this->acceptsType($value)) {
            throw $this->doUnexpectedValueError($value);
        }

        parent::set($key, $value);
    }

    /**
     * @param $element
     *
     * @return UnexpectedValueException
     */
    private function doUnexpectedValueError($element)
    {
        return new UnexpectedValueException(sprintf(
            '"%s" does not match the expected type.',
            is_object($element) ? get_class($element) : gettype($element)
        ));
    }

    /**
     * @param $value
     *
     * @return bool
     */
    abstract public function acceptsType($value);
}
