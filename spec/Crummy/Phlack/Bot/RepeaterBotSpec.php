<?php

namespace spec\Crummy\Phlack\Bot;

use Crummy\Phlack\Common\Matcher\NonMatcher;
use Crummy\Phlack\WebHook\CommandInterface;
use Crummy\Phlack\WebHook\Reply;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RepeaterBotSpec extends ObjectBehavior
{
    function it_is_a_repeater_bot()
    {
        $this->shouldHaveType('Crummy\Phlack\Bot\RepeaterBot');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\Bot\AbstractBot');
    }

    function it_does_the_repeater(CommandInterface $command)
    {
        $command->getText()->willReturn('Would you mind stepping down from there, with your license and registration?');
        $this
            ->execute($command)['text']
                ->shouldReturn('Would you mind stepping down from there, with your license and registration?');
    }

    function it_sets_and_gets_a_matcher(NonMatcher $matcher)
    {
        $this->setMatcher($matcher)->shouldReturn($this);
        $this->getMatcher()->shouldReturn($matcher);
    }
}
