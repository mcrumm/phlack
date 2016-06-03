<?php

namespace spec\Crummy\Phlack\WebHook;

use Crummy\Phlack\Bot\BotInterface;
use Crummy\Phlack\Common\Event;
use Crummy\Phlack\WebHook\Matcher\DefaultMatcher;
use Crummy\Phlack\WebHook\Matcher\MatcherInterface;
use Crummy\Phlack\WebHook\CommandInterface;
use PhpSpec\ObjectBehavior;

class MainframeSpec extends ObjectBehavior
{
    function it_is_an_executable()
    {
        $this->shouldHaveType('Crummy\Phlack\WebHook\Mainframe');
        $this->shouldImplement('\Crummy\Phlack\WebHook\Executable');
    }

    function it_creates_a_listener_for_a_bot_and_matcher(BotInterface $bot, MatcherInterface $matcher)
    {
        $this->getListener($bot, $matcher)->shouldBeCallable();
    }

    function it_fluently_attaches_bots_and_matchers(BotInterface $bot, DefaultMatcher $matcher)
    {
        $this->attach($bot, $matcher)->shouldReturn($this);
    }

    function its_listener_executes_commands_on_match(BotInterface $bot, MatcherInterface $matcher, CommandInterface $command, Event $event)
    {
        $event->offsetGet('command')->willReturn($command);
        $event->offsetSet('message', null)->shouldBeCalled();

        $matcher->matches($command)->willReturn(true);
        $event->stopPropagation()->shouldBeCalled();
        $bot->execute($command)->shouldBeCalled();

        $listener = $this->getListener($bot, $matcher);
        $listener($event);
    }

    function its_listener_does_not_execute_without_match(BotInterface $bot, MatcherInterface $matcher, CommandInterface $command, Event $event)
    {
        $event->offsetGet('command')->willReturn($command);

        $matcher->matches($command)->willReturn(false);

        $event->stopPropagation()->shouldNotBeCalled();
        $bot->execute($command)->shouldNotBeCalled();

        $listener = $this->getListener($bot, $matcher);
        $listener($event);
    }

    function its_listener_can_accept_a_callable_as_a_matcher(BotInterface $bot, CommandInterface $command, Event $event)
    {
        $event->offsetGet('command')->willReturn($command);
        $event->offsetSet('message', null)->shouldBeCalled();

        $event->stopPropagation()->shouldBeCalled();
        $bot->execute($command)->shouldBeCalled();

        $listener = $this->getListener($bot, function ($command) { return true; });
        $listener($event);
    }

    function its_listener_throws_an_exception_for_non_callable_matchers(BotInterface $bot)
    {
        $this
            ->shouldThrow('\Crummy\Phlack\Common\Exception\InvalidArgumentException')
                ->during('getListener', [$bot, true]);
    }
}
