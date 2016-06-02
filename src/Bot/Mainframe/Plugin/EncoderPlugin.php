<?php

namespace Crummy\Phlack\Bot\Mainframe\Plugin;

use Crummy\Phlack\Common\Event;
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
     * @param Event $event
     *
     * @return Event
     */
    public function onAfterExecute(Event $event)
    {
        if (isset($event['message'])) {
            $event['message']['text'] = $this->formatter->format($event['message']['text']);
        }

        return $event;
    }
}
