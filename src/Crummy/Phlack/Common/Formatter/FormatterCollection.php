<?php

namespace Crummy\Phlack\Common\Formatter;

use Crummy\Phlack\Common\Collection\TypeCollection;

class FormatterCollection extends TypeCollection implements FormatterInterface
{
    /**
     * @param string $text
     *
     * @return string
     */
    public function format($text)
    {
        /** @var FormatterInterface $formatter */
        foreach ($this->toArray() as $formatter) {
            $text = $formatter->format($text);
        }

        return $text;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function acceptsType($value)
    {
        return $value instanceof FormatterInterface;
    }
}
