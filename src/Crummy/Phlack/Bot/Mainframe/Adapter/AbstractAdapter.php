<?php

namespace Crummy\Phlack\Bot\Mainframe\Adapter;

use Crummy\Phlack\Bot\BotInterface;
use Crummy\Phlack\Bot\Mainframe\Mainframe;
use Crummy\Phlack\Common\Matcher\MatcherInterface;
use Crummy\Phlack\WebHook\Converter\ConverterInterface;
use Crummy\Phlack\WebHook\Converter\StringConverter;

class AbstractAdapter implements AdapterInterface
{
    /** @var Mainframe */
    protected $mainframe;

    /** @var StringConverter|ConverterInterface */
    protected $converter;

    /**
     * @param Mainframe          $mainframe
     * @param ConverterInterface $converter
     */
    public function __construct(Mainframe $mainframe, ConverterInterface $converter = null)
    {
        $this->setMainframe($mainframe);
        $this->converter = $converter ?: new StringConverter();
    }

    /**
     * @param Mainframe $mainframe
     *
     * @return self
     */
    public function setMainframe(Mainframe $mainframe)
    {
        $this->mainframe = $mainframe;

        return $this;
    }

    /**
     * @return \Crummy\Phlack\WebHook\Converter\ConverterInterface
     */
    public function getConverter()
    {
        return $this->converter;
    }

    /**
     * @param BotInterface              $bot
     * @param MatcherInterface|callable $matcher
     * @param int                       $priority
     *
     * @return self
     */
    public function attach(BotInterface $bot, $matcher = null, $priority = 0)
    {
        $this->mainframe->attach($bot, $matcher, $priority);

        return $this;
    }
}
