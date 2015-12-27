<?php

namespace Crummy\Phlack\Common\Exception;

class UnexpectedTypeException extends \InvalidArgumentException
{
    /**
     * @param mixed        $value
     * @param string|array $expectedType
     */
    public function __construct($value, $expectedType)
    {
        parent::__construct(sprintf(
            'Expected argument of type %s, %s given.',
            is_array($expectedType) ? '('.implode(' | ', $expectedType).')' : $expectedType,
            is_object($value) ? get_class($value) : gettype($value)
        ));
    }
}
