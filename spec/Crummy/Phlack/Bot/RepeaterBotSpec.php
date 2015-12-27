<?php

namespace spec\Crummy\Phlack\Bot;

use Crummy\Phlack\Common\Matcher\NonMatcher;
use Crummy\Phlack\WebHook\CommandInterface;
use Crummy\Phlack\WebHook\WebHook;
use PhpSpec\ObjectBehavior;

class RepeaterBotSpec extends ObjectBehavior
{
    public function it_is_a_repeater_bot()
    {
        $this->shouldHaveType('Crummy\Phlack\Bot\RepeaterBot');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\Bot\AbstractBot');
    }

    public function it_does_the_repeater(WebHook $command)
    {
        $command->offsetGet('channel_id')->willReturn('C98765');
        $command->offsetGet('channel_name')->willReturn('group');
        $command->offsetGet('user_id')->willReturn('U12345');
        $command->offsetGet('user_name')->willReturn('crumm');
        $command->offsetGet('text')->willReturn('Would you mind stepping down from there, with your license and registration?');
        $command->offsetGet('command')->willReturn('would:');
        $this
            ->execute($command)['text']
                ->shouldReturn('<@U12345|crumm> Would you mind stepping down from there, with your license and registration?');
    }

    public function it_sets_and_gets_a_matcher(NonMatcher $matcher)
    {
        $this->setMatcher($matcher)->shouldReturn($this);
        $this->getMatcher()->shouldReturn($matcher);
    }

    public function it_sets_and_gets_a_callable_matcher()
    {
        $matcher = function (CommandInterface $command) {
            return true;
        };

        $this->setMatcher($matcher)->shouldReturn($this);
        $this->getMatcher()->shouldBeCallable();
    }

    public function it_fails_to_set_an_invalid_matcher()
    {
        $this
            ->shouldThrow('\Crummy\Phlack\Common\Exception\InvalidArgumentException')
                ->during('setMatcher', ['matcher']);
    }

    public function it_strips_the_command_from_the_webhook_text(WebHook $command)
    {
        $command->offsetGet('channel_id')->willReturn('C98765');
        $command->offsetGet('channel_name')->willReturn('group');
        $command->offsetGet('user_id')->willReturn('U12345');
        $command->offsetGet('user_name')->willReturn('crumm');
        $command->offsetGet('command')->willReturn('foo:');
        $command->offsetGet('text')->willReturn('foo: bar');
        $this
            ->execute($command)['text']
                ->shouldReturn('<@U12345|crumm> bar');
    }

    public function it_does_not_strip_the_first_word_if_not_the_command(WebHook $command)
    {
        $command->offsetGet('channel_id')->willReturn('C98765');
        $command->offsetGet('channel_name')->willReturn('group');
        $command->offsetGet('user_id')->willReturn('U12345');
        $command->offsetGet('user_name')->willReturn('crumm');
        $command->offsetGet('command')->willReturn('foo:');
        $command->offsetGet('text')->willReturn('foo bar');
        $this
            ->execute($command)['text']
            ->shouldReturn('<@U12345|crumm> foo bar');
    }

    public function it_does_not_strip_multiple_occurrences(WebHook $command)
    {
        $command->offsetGet('channel_id')->willReturn('C98765');
        $command->offsetGet('channel_name')->willReturn('group');
        $command->offsetGet('user_id')->willReturn('U12345');
        $command->offsetGet('user_name')->willReturn('crumm');
        $command->offsetGet('command')->willReturn('foo:');
        $command->offsetGet('text')->willReturn('foo: bar foo: bat foo baz foo: you');
        $this
            ->execute($command)['text']
            ->shouldReturn('<@U12345|crumm> bar foo: bat foo baz foo: you');
    }
}
