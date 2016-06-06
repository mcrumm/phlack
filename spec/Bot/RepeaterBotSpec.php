<?php

namespace spec\Crummy\Phlack\Bot;

use Crummy\Phlack\WebHook\Command;
use Crummy\Phlack\WebHook\Matcher\NonMatcher;
use PhpSpec\ObjectBehavior;

class RepeaterBotSpec extends ObjectBehavior
{
    function it_is_a_repeater_bot()
    {
        $this->shouldHaveType('Crummy\Phlack\Bot\RepeaterBot');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\Bot\AbstractBot');
    }

    function it_does_the_repeater()
    {
        $command = new Command([
            'channel_id' => 'C98765',
            'channel_name' => 'group',
            'user_id' => 'U12345',
            'user_name' => 'crumm',
            'command' => 'would:',
            'text' => 'Would you mind stepping down from there, with your license and registration?',
        ]);

        $this
            ->execute($command)['text']
                ->shouldReturn('<@U12345|crumm> Would you mind stepping down from there, with your license and registration?');
    }

    function it_sets_and_gets_a_matcher(NonMatcher $matcher)
    {
        $this->setMatcher($matcher)->shouldReturn($this);
        $this->getMatcher()->shouldReturn($matcher);
    }

    function it_sets_and_gets_a_callable_matcher()
    {
        $matcher = function (Command $command) {
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

    function it_strips_the_command_from_the_webhook_text()
    {
        $command = new Command([
            'channel_id' => 'C98765',
            'channel_name' => 'group',
            'user_id' => 'U12345',
            'user_name' => 'crumm',
            'command' => 'foo:',
            'text' => 'foo: bar',
        ]);

        $this
            ->execute($command)['text']
                ->shouldReturn('<@U12345|crumm> bar');
    }

    function it_does_not_strip_the_first_word_if_not_the_command()
    {
        $command = new Command([
            'channel_id' => 'C98765',
            'channel_name' => 'group',
            'user_id' => 'U12345',
            'user_name' => 'crumm',
            'command' => 'foo:',
            'text' => 'foo bar',
        ]);

        $this
            ->execute($command)['text']
            ->shouldReturn('<@U12345|crumm> foo bar');
    }

    function it_does_not_strip_multiple_occurrences()
    {
        $command = new Command([
            'channel_id' => 'C98765',
            'channel_name' => 'group',
            'user_id' => 'U12345',
            'user_name' => 'crumm',
            'command' => 'foo:',
            'text' => 'foo: bar foo: bat foo baz foo: you',
        ]);

        $this
            ->execute($command)['text']
            ->shouldReturn('<@U12345|crumm> bar foo: bat foo baz foo: you');
    }
}
