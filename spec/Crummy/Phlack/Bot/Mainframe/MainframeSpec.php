<?php

namespace spec\Crummy\Phlack\Bot\Mainframe;

use Crummy\Phlack\Bot\BotInterface;
use Crummy\Phlack\Bot\Mainframe\Cpu;
use Crummy\Phlack\Bot\Mainframe\Packet;
use Crummy\Phlack\Common\Events;
use Crummy\Phlack\Common\Matcher\DefaultMatcher;
use Crummy\Phlack\Common\Matcher\MatcherInterface;
use Crummy\Phlack\WebHook\CommandInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MainframeSpec extends ObjectBehavior
{
    function it_is_an_executable()
    {
        $this->shouldHaveType('Crummy\Phlack\Bot\Mainframe\Mainframe');
        $this->shouldImplement('\Crummy\Phlack\Common\Executable');
    }

    function it_creates_a_listener_for_a_bot_and_matcher(BotInterface $bot, MatcherInterface $matcher)
    {
        $this->getListener($bot, $matcher)->shouldBeCallable();
    }

    function it_fluently_attaches_bots_and_matchers(BotInterface $bot, DefaultMatcher $matcher)
    {
        $this->attach($bot, $matcher)->shouldReturn($this);
    }

    function its_listener_executes_commands_on_match(BotInterface $bot, MatcherInterface $matcher, CommandInterface $command, Packet $packet)
    {
        $packet->offsetGet('command')->willReturn($command);
        $packet->offsetSet('output', null)->shouldBeCalled();

        $matcher->matches($command)->willReturn(true);
        $packet->stopPropagation()->shouldBeCalled();
        $bot->execute($command)->shouldBeCalled();

        $listener = $this->getListener($bot, $matcher);
        $listener($packet);
    }

    function its_listener_does_not_execute_without_match(BotInterface $bot, MatcherInterface $matcher, CommandInterface $command, Packet $packet)
    {
        $packet->offsetGet('command')->willReturn($command);

        $matcher->matches($command)->willReturn(false);

        $packet->stopPropagation()->shouldNotBeCalled();
        $bot->execute($command)->shouldNotBeCalled();

        $listener = $this->getListener($bot, $matcher);
        $listener($packet);
    }
}
