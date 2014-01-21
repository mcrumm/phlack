<?php

namespace Crummy\Phlack\Message;

class Field extends Partial implements FieldInterface
{
    /**
     * Constructor.
     * @param string $title
     * @param string $value
     * @param boolean $isShort
     */
    public function __construct($title = null, $value = null, $isShort = null)
    {
        if ($title)   { $this->setTitle($title); }
        if ($value)   { $this->setValue($value); }
        if (isset($isShort)) { $this->setShort($isShort); }
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        return $this->set('title', $title);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        return $this->set('value', $value);
    }

    /**
     * @param boolean $isShort
     * @return $this
     */
    public function setShort($isShort)
    {
        return $this->set('short', (boolean)$isShort);
    }

    /**
     * @return boolean
     */
    public function isShort()
    {
        return isset($this->data['short']) ? $this->data['short'] : true;
    }
}
