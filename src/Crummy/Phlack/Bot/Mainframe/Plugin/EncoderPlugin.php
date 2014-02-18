<?php

namespace Crummy\Phlack\Bot\Mainframe\Plugin;

use Crummy\Phlack\Bot\Mainframe\Packet;
use Crummy\Phlack\Common\Events;
use Crummy\Phlack\Common\Formatter\SlackFormatter;

class EncoderPlugin implements PluginInterface
{
    private $formatter;

    /**
     * @param SlackFormatter $formatter
     */
    function __construct(SlackFormatter $formatter = null)
    {
        $this->formatter = $formatter ?: new SlackFormatter();
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
       return [
           Events::AFTER_EXECUTE_COMMAND => 'onAfterExecute'
       ];
    }

    /**
     * @param Packet $packet
     * @return Packet
     */
    public function onAfterExecute(Packet $packet)
    {
        if (isset($packet['output'])) {
            $this->formatter->setMessage($packet['output']);
            $packet['output']['text'] = $this->formatter->formatText();
        }

        return $packet;
    }
}
