<?php

namespace Crummy\Phlack\Common\Formatter;

class EncodeFormatter implements FormatterInterface
{
    private $guards = ['^(', ')^'];

    /**
     * @param string $text
     *
     * @return string
     */
    public function format($text)
    {
        $replacement = implode('', [$this->guards[0], '$1', $this->guards[1]]);
        $text = preg_replace('/<(.*)>/U', $replacement, $text);
        $text = htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8', false);

        return str_replace($this->guards, ['<', '>'], $text);
    }
}
