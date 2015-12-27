<?php

namespace Crummy\Phlack\Bot\Mainframe\Plugin;

use Crummy\Phlack\Bot\Mainframe\Packet;
use Crummy\Phlack\Common\Events;
use Crummy\Phlack\Common\Formatter\EncodeFormatter;
use Crummy\Phlack\Common\Formatter\FormatterCollection;
use Crummy\Phlack\Common\Formatter\FormatterInterface;
use Crummy\Phlack\Common\Formatter\LinkFormatter;

class EncoderPlugin implements PluginInterface
{
    private $formatter;

    /**
     * @param FormatterInterface $formatter
     */
    public function __construct(FormatterInterface $formatter = null)
    {
        $this->formatter = $formatter ?: new FormatterCollection([
            new LinkFormatter(),
            new EncodeFormatter(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
           Events::AFTER_EXECUTE_COMMAND => 'onAfterExecute',
       ];
    }

    /**
     * @param Packet $packet
     *
     * @return Packet
     */
    public function onAfterExecute(Packet $packet)
    {
        if (isset($packet['output'])) {
            $packet['output']['text'] = $this->formatter->format($packet['output']['text']);
        }

        return $packet;
    }
}
