<?php

namespace Crummy\Phlack\Bot\Mainframe;

use Crummy\Phlack\Bot\BotInterface;
use Crummy\Phlack\Common\Events;
use Crummy\Phlack\Common\Executable;
use Crummy\Phlack\Common\Matcher\DefaultMatcher;
use Crummy\Phlack\Common\Matcher\MatcherAggregate;
use Crummy\Phlack\Common\Matcher\MatcherInterface;
use Crummy\Phlack\WebHook\CommandInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Mainframe implements Executable
{
    private $cpu;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->cpu = new EventDispatcher();
    }

    /**
     * @param CommandInterface $command
     * @return Packet
     */
    public function execute(CommandInterface $command)
    {
        $packet = new Packet([ 'command' => $command ]);
        return $this->cpu->dispatch(Events::RECEIVED_COMMAND, $packet);
    }

    /**
     * @param BotInterface $bot
     * @param MatcherInterface $matcher
     * @param int $priority
     * @return self
     */
    public function attach(BotInterface $bot, MatcherInterface $matcher = null, $priority = 0)
    {
        if (!$matcher && $bot instanceof MatcherAggregate) {
            $matcher = $bot->getMatcher();
        } else {
            $matcher = new DefaultMatcher();
        }

        $this->cpu->addListener(Events::RECEIVED_COMMAND, $this->getListener($bot, $matcher), $priority);

        return $this;
    }

    /**
     * @param BotInterface $bot
     * @param MatcherInterface $matcher
     * @return callable
     */
    public function getListener(BotInterface $bot, MatcherInterface $matcher)
    {
        return function (Packet $packet) use ($bot, $matcher) {
            if ($matcher->matches($packet['command'])) {
                $packet->stopPropagation();
                $packet['output'] = $bot->execute($packet['command']);
            }
        };
    }
}
