<?php

namespace Crummy\Phlack\Common\Formatter;

use Crummy\Phlack\WebHook\CommandInterface;

class Sequencer implements FormatterInterface
{
    const SEQUENCE = '<%s>';

    /**
     * @param string $text  The text to be sequenced
     * @param string $label An optional label
     * @return string
     */
    public function format($text, $label = null)
    {
        return $this->sequence($text, $label);
    }

    /**
     * @param string $text
     * @param null $label
     * @return string
     */
    static public function sequence($text, $label = null)
    {
        $text = $label ? $text.'|'.$label : $text;
        return sprintf(static::SEQUENCE, $text);
    }

    /**
     * @param CommandInterface $command
     * @return array
     */
    static public function command(CommandInterface $command)
    {
        return [
            'channel'   => self::sequence('#'.$command['channel_id'], $command['channel_name']),
            'user'      => self::sequence('@'.$command['user_id'], $command['user_name']),
        ];
    }

    /**
     * @param string $channel
     * @return string
     */
    static public function alert($channel)
    {
        return self::sequence('!'.$channel);
    }
}
