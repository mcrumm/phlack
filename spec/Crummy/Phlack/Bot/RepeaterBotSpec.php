<?php

namespace spec\Crummy\Phlack\Bot;

use Crummy\Phlack\Common\Matcher\NonMatcher;
use Crummy\Phlack\WebHook\CommandInterface;
use Crummy\Phlack\WebHook\Reply;
use Crummy\Phlack\WebHook\WebHook;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RepeaterBotSpec extends ObjectBehavior
{
    function it_is_a_repeater_bot()
    {
        $this->shouldHaveType('Crummy\Phlack\Bot\RepeaterBot');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\Bot\AbstractBot');
    }

    function it_does_the_repeater(WebHook $command)
    {
        $command->get('user_name')->willReturn('mcrumm');
        $command->get('text')->willReturn('Would you mind stepping down from there, with your license and registration?');
        $command->get('command')->willReturn('would:');
        $this
            ->execute($command)['text']
                ->shouldReturn('@mcrumm Would you mind stepping down from there, with your license and registration?');
    }

    function it_sets_and_gets_a_matcher(NonMatcher $matcher)
    {
        $this->setMatcher($matcher)->shouldReturn($this);
        $this->getMatcher()->shouldReturn($matcher);
    }

    function it_strips_the_command_from_the_webhook_text(WebHook $command)
    {
        $command->get('user_name')->willReturn('mcrumm');
        $command->get('command')->willReturn('foo:');
        $command->get('text')->willReturn('foo: bar');
        $this
            ->execute($command)['text']
                ->shouldReturn('@mcrumm bar');
    }

    function it_does_not_strip_the_first_word_if_not_the_command(WebHook $command)
    {
        $command->get('user_name')->willReturn('mcrumm');
        $command->get('command')->willReturn('foo:');
        $command->get('text')->willReturn('foo bar');
        $this
            ->execute($command)['text']
            ->shouldReturn('@mcrumm foo bar');
    }
}
