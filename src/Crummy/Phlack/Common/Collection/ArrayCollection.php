<?php

namespace Crummy\Phlack\Common\Collection;

use Doctrine\Common\Collections\ArrayCollection as BaseCollection;

class ArrayCollection extends BaseCollection
{
    /**
     * Resets the elements in the array with the elements given.
     * @param array $elements
     * @return $this
     */
    public function reset(array $elements = [ ])
    {
        $this->clear();
        foreach ($elements as $element) {
            $this->add($element);
        }
        return $this;
    }
}
 