<?php

namespace Crummy\Phlack\WebHook\Mainframe\Plugin;

use Crummy\Phlack\Common\Events;
use Crummy\Phlack\Common\Formatter\EncodeFormatter;
use Crummy\Phlack\Common\Formatter\FormatterCollection;
use Crummy\Phlack\Common\Formatter\FormatterInterface;
use Crummy\Phlack\Common\Formatter\LinkFormatter;
use Crummy\Phlack\WebHook\Mainframe\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EncoderPlugin implements EventSubscriberInterface
{
    /**
     * @var FormatterInterface
     */
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
