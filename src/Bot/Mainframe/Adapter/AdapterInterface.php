<?php

namespace Crummy\Phlack\Bot\Mainframe\Adapter;

use Crummy\Phlack\Bot\BotInterface;
use Crummy\Phlack\Bot\Mainframe\Mainframe;
use Crummy\Phlack\WebHook\Converter\ConverterInterface;
use Crummy\Phlack\WebHook\Matcher\MatcherInterface;

interface AdapterInterface
{
    /**
     * @param Mainframe $mainframe
     *
     * @return self
     */
    public function setMainframe(Mainframe $mainframe);

    /**
     * @return callable|ConverterInterface
     */
    public function getConverter();

    /**
     * @param BotInterface              $bot
     * @param MatcherInterface|callable $matcher
     * @param int                       $priority
     *
     * @return self
     */
    public function attach(BotInterface $bot, $matcher = null, $priority = 0);
}
