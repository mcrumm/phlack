<?php

namespace Crummy\Phlack\Common\Formatter;

class LinkFormatter implements FormatterInterface
{
    const HTML = '/ <a (?:.*?) href=[\'"](.+)[\'"] (?:.*)> (.+?) <\/a> /x';
    const MARKDOWN = '/\[(.*?)\]\((.+?)\)/';

    /**
     * @param string $text
     *
     * @return string
     */
    public function format($text)
    {
        $text = preg_replace_callback(self::HTML, $this->getMatchFormatter(), $text);
        $text = preg_replace_callback(self::MARKDOWN, $this->getMatchFormatter(2, 1), $text);

        return $text;
    }

    /**
     * @param int $linkIdx  The index of the matches containing the resource link
     * @param int $labelIdx The index of the matches containing the label (if one exists)
     *
     * @return \Closure A callable to be passed to preg_replace_callback
     */
    protected function getMatchFormatter($linkIdx = 1, $labelIdx = 2)
    {
        return function (array $matches) use ($linkIdx, $labelIdx) {
            $out = '<';
            $out .= $matches[$linkIdx];
            if (!empty($matches[$labelIdx])) {
                $out .= '|'.$matches[$labelIdx];
            }
            $out .= '>';

            return $out;
        };
    }
}
