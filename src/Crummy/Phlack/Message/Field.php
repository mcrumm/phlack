<?php

namespace Crummy\Phlack\Message;

class Field extends Partial implements FieldInterface
{
    protected $required = [ 'title', 'value', 'short' ];

    /**
     * Constructor.
     * @param string $title
     * @param string $value
     * @param boolean $isShort
     */
    public function __construct($title = null, $value = null, $isShort = null)
    {
        parent::__construct([ 'title' => $title, 'value' => $value, 'short' => $isShort ]);
    }

    /**
     * @param string $title
     * @return $this
     * @deprecated Will be removed in 0.6.0
     */
    public function setTitle($title)
    {
        $this['title'] = $title;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     * @deprecated Will be removed in 0.6.0
     */
    public function setValue($value)
    {
        $this['value'] = $value;
        return $this;
    }

    /**
     * @param boolean $isShort
     * @return $this
     * @deprecated Will be removed in 0.6.0
     */
    public function setShort($isShort)
    {
        $this['short'] = (boolean)$isShort;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isShort()
    {
        return isset($this['short']) ? $this['short'] : false;
    }
}
