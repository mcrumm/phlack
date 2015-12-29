<?php

namespace Crummy\Phlack\Common\Formatter;

interface FormatterInterface
{
    /**
     * @param string $text
     *
     * @return string
     */
    public function format($text);
}
