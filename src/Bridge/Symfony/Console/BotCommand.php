<?php

namespace Crummy\Phlack\Bridge\Symfony\Console;

use Crummy\Phlack\Bot\BotInterface;
use Crummy\Phlack\Bot\Mainframe\Adapter\AdapterInterface;
use Crummy\Phlack\Bot\Mainframe\Mainframe;
use Crummy\Phlack\Common\Matcher\MatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BotCommand extends Command implements AdapterInterface
{
    private $adapter;

    /**
     * @param ConsoleAdapter $adapter
     * @param string         $name
     */
    public function __construct(ConsoleAdapter $adapter, $name = 'bot_command')
    {
        parent::__construct($name);

        $this->adapter = $adapter;
    }

    /**
     * @param Mainframe $mainframe
     *
     * @return self
     */
    public function setMainframe(Mainframe $mainframe)
    {
        $this->adapter->setMainframe($mainframe);

        return $this;
    }

    /**
     * @return \Crummy\Phlack\WebHook\Converter\ConverterInterface
     */
    public function getConverter()
    {
        return $this->adapter->getConverter();
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
        $this->adapter->attach($bot, $matcher, $priority);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->adapter->execute($input, $output);
    }
}
