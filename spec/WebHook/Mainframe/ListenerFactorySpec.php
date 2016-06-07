<?php

namespace spec\Crummy\Phlack\WebHook\Mainframe;

use Crummy\Phlack\Common\Event;
use Crummy\Phlack\WebHook\Command;
use Crummy\Phlack\WebHook\Executable;
use Crummy\Phlack\WebHook\Matcher\DefaultMatcher;
use Crummy\Phlack\WebHook\Matcher\NonMatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ListenerFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\WebHook\Mainframe\ListenerFactory');
    }

    function it_creates_a_listener_for_a_bot_and_matcher(Executable $bot)
    {
        $this->newListener($bot, new DefaultMatcher())->shouldBeCallable();
    }

    function it_executes_the_command_on_match(Executable $bot, Command $command, Event $event)
    {
        $event->offsetGet('command')->willReturn($command);
        $event->offsetSet('message', null)->shouldBeCalled();

        $event->stopPropagation()->shouldBeCalled();
        $bot->execute($command)->shouldBeCalled();

        $listener = $this->newListener($bot, new DefaultMatcher());
        $listener($event);
    }

    function it_does_not_execute_without_match(Executable $bot, Command $command, Event $event)
    {
        $event->offsetGet('command')->willReturn($command);

        $event->stopPropagation()->shouldNotBeCalled();
        $bot->execute($command)->shouldNotBeCalled();

        $listener = $this->newListener($bot, new NonMatcher());
        $listener($event);
    }

    function it_will_accept_a_callable_as_a_matcher(Executable $bot, Command $command, Event $event)
    {
        $event->offsetGet('command')->willReturn($command);
        $event->offsetSet('message', null)->shouldBeCalled();

        $event->stopPropagation()->shouldBeCalled();
        $bot->execute($command)->shouldBeCalled();

        $listener = $this->newListener($bot, function () { return true; });
        $listener($event);
    }

    function it_throws_an_exception_for_non_callable_matchers(Executable $bot)
    {
        $this
            ->shouldThrow('\Crummy\Phlack\Common\Exception\UnexpectedTypeException')
            ->during('newListener', [$bot, true]);
    }
}
