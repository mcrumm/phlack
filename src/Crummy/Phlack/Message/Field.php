<?php

namespace Crummy\Phlack\Message;

class Field extends Partial implements FieldInterface
{
    protected $optional = ['title', 'value', 'short'];

    /**
     * Constructor.
     *
     * @param string $title
     * @param string $value
     * @param bool   $isShort
     */
    public function __construct($title = null, $value = null, $isShort = null)
    {
        parent::__construct(['title' => $title, 'value' => $value, 'short' => $isShort]);
    }

    /**
     * @return bool
     */
    public function isShort()
    {
        return isset($this['short']) ? $this['short'] : false;
    }
}
