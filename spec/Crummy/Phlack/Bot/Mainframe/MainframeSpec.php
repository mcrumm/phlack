<?php

namespace spec\Crummy\Phlack\Bot\Mainframe;

use Crummy\Phlack\Bot\BotInterface;
use Crummy\Phlack\Bot\Mainframe\Packet;
use Crummy\Phlack\Common\Matcher\DefaultMatcher;
use Crummy\Phlack\Common\Matcher\MatcherInterface;
use Crummy\Phlack\WebHook\CommandInterface;
use PhpSpec\ObjectBehavior;

class MainframeSpec extends ObjectBehavior
{
    public function it_is_an_executable()
    {
        $this->shouldHaveType('Crummy\Phlack\Bot\Mainframe\Mainframe');
        $this->shouldImplement('\Crummy\Phlack\Common\Executable');
    }

    public function it_creates_a_listener_for_a_bot_and_matcher(BotInterface $bot, MatcherInterface $matcher)
    {
        $this->getListener($bot, $matcher)->shouldBeCallable();
    }

    public function it_fluently_attaches_bots_and_matchers(BotInterface $bot, DefaultMatcher $matcher)
    {
        $this->attach($bot, $matcher)->shouldReturn($this);
    }

    public function its_listener_executes_commands_on_match(BotInterface $bot, MatcherInterface $matcher, CommandInterface $command, Packet $packet)
    {
        $packet->offsetGet('command')->willReturn($command);
        $packet->offsetSet('output', null)->shouldBeCalled();

        $matcher->matches($command)->willReturn(true);
        $packet->stopPropagation()->shouldBeCalled();
        $bot->execute($command)->shouldBeCalled();

        $listener = $this->getListener($bot, $matcher);
        $listener($packet);
    }

    public function its_listener_does_not_execute_without_match(BotInterface $bot, MatcherInterface $matcher, CommandInterface $command, Packet $packet)
    {
        $packet->offsetGet('command')->willReturn($command);

        $matcher->matches($command)->willReturn(false);

        $packet->stopPropagation()->shouldNotBeCalled();
        $bot->execute($command)->shouldNotBeCalled();

        $listener = $this->getListener($bot, $matcher);
        $listener($packet);
    }

    public function its_listener_can_accept_a_callable_as_a_matcher(BotInterface $bot, CommandInterface $command, Packet $packet)
    {
        $packet->offsetGet('command')->willReturn($command);
        $packet->offsetSet('output', null)->shouldBeCalled();

        $packet->stopPropagation()->shouldBeCalled();
        $bot->execute($command)->shouldBeCalled();

        $listener = $this->getListener($bot, function ($command) { return true; });
        $listener($packet);
    }

    public function its_listener_throws_an_exception_for_non_callable_matchers(BotInterface $bot)
    {
        $this
            ->shouldThrow('\Crummy\Phlack\Common\Exception\InvalidArgumentException')
                ->during('getListener', [$bot, true]);
    }
}
