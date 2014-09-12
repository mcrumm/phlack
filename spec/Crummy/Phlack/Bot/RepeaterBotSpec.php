<?php

namespace spec\Crummy\Phlack\Bot;

use Crummy\Phlack\Common\Iterocitor;
use Crummy\Phlack\Common\Matcher\NonMatcher;
use Crummy\Phlack\WebHook\CommandInterface;
use Crummy\Phlack\WebHook\Reply\Reply;
use Crummy\Phlack\WebHook\WebHook;
use PhpSpec\ObjectBehavior;

class RepeaterBotSpec extends ObjectBehavior
{
    function let(Iterocitor $iterocitor)
    {
        $this->beConstructedWith(null, $iterocitor);
    }

    function it_is_a_repeater_bot()
    {
        $this->shouldHaveType('Crummy\Phlack\Bot\RepeaterBot');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\Bot\AbstractBot');
    }

    function it_does_the_repeater($iterocitor, WebHook $command, Reply $reply)
    {
        $message    = 'Would you mind stepping down from there, with your license and registration?';
        $response   = '<@U12345|crumm> Would you mind stepping down from there, with your license and registration?';
        $reply->offsetGet('text')->willReturn($response);
        $iterocitor->reply($command, $message)->willReturn($reply);

        $command->offsetGet('channel_id')->willReturn('C98765');
        $command->offsetGet('channel_name')->willReturn('group');
        $command->offsetGet('user_id')->willReturn('U12345');
        $command->offsetGet('user_name')->willReturn('crumm');
        $command->offsetGet('text')->willReturn($message);
        $command->offsetGet('command')->willReturn('would:');

        $this
            ->execute($command)['text']
                ->shouldReturn($response);
    }

    function it_sets_and_gets_a_matcher(NonMatcher $matcher)
    {
        $this->setMatcher($matcher)->shouldReturn($this);
        $this->getMatcher()->shouldReturn($matcher);
    }

    function it_sets_and_gets_a_callable_matcher()
    {
        $matcher = function (CommandInterface $command) {
            return true;
        };

        $this->setMatcher($matcher)->shouldReturn($this);
        $this->getMatcher()->shouldBeCallable();
    }

    function it_fails_to_set_an_invalid_matcher()
    {
        $this
            ->shouldThrow('\Crummy\Phlack\Common\Exception\InvalidArgumentException')
                ->during('setMatcher', ['matcher']);
    }

    function it_strips_the_command_from_the_webhook_text($iterocitor, WebHook $command, Reply $reply)
    {
        $user       = '<@U12345|crumm>';
        $text       = 'bar';
        $message    = $user . ' ' . $text;

        $iterocitor->reply($command, $text)->willReturn($reply);
        $reply->offsetGet('text')->willReturn($message);

        $command->offsetGet('channel_id')->willReturn('C98765');
        $command->offsetGet('channel_name')->willReturn('group');
        $command->offsetGet('user_id')->willReturn('U12345');
        $command->offsetGet('user_name')->willReturn('crumm');
        $command->offsetGet('command')->willReturn('foo:');
        $command->offsetGet('text')->willReturn('foo: bar');
        $this
            ->execute($command)['text']
                ->shouldReturn($message);
    }

    function it_does_not_strip_the_first_word_if_not_the_command($iterocitor, WebHook $command, Reply $reply)
    {
        $message    = 'foo bar';
        $response   = '<@U12345|crumm> foo bar';

        $reply->offsetGet('text')->willReturn($response);
        $iterocitor->reply($command, $message)->willReturn($reply);

        $command->offsetGet('channel_id')->willReturn('C98765');
        $command->offsetGet('channel_name')->willReturn('group');
        $command->offsetGet('user_id')->willReturn('U12345');
        $command->offsetGet('user_name')->willReturn('crumm');
        $command->offsetGet('command')->willReturn('foo:');
        $command->offsetGet('text')->willReturn($message);

        $this
            ->execute($command)['text']
            ->shouldReturn($response);
    }

    function it_does_not_strip_multiple_occurrences($iterocitor, WebHook $command, Reply $reply)
    {
        $message    = 'foo: bar foo: bat foo baz foo: you';
        $repeated   = 'bar foo: bat foo baz foo: you';
        $response   = '<@U12345|crumm> bar foo: bat foo baz foo: you';

        $reply->offsetGet('text')->willReturn($response);
        $iterocitor->reply($command, $repeated)->willReturn($reply);

        $command->offsetGet('channel_id')->willReturn('C98765');
        $command->offsetGet('channel_name')->willReturn('group');
        $command->offsetGet('user_id')->willReturn('U12345');
        $command->offsetGet('user_name')->willReturn('crumm');
        $command->offsetGet('command')->willReturn('foo:');
        $command->offsetGet('text')->willReturn($message);

        $this
            ->execute($command)['text']
            ->shouldReturn($response);
    }
}
