<?php

namespace spec\Crummy\Phlack\Common\Matcher;

use Crummy\Phlack\WebHook\SlashCommand;
use Crummy\Phlack\WebHook\WebHook;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandNameMatcherSpec extends ObjectBehavior
{
    function it_is_a_matcher()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Matcher\CommandNameMatcher');
        $this->shouldImplement('\Crummy\Phlack\Common\Matcher\MatcherInterface');
    }

    function it_sets_command_name()
    {
        $this->setCommandName('foo:')->shouldReturn($this);

        $this
            ->getCommandName()
                ->shouldReturn('foo:');
    }

    function it_matches_a_SlashCommand_by_name(SlashCommand $command)
    {
        $command->get('command')->willReturn('/foo');

        $this
            ->setCommandName('/foo')
                ->matches($command)
                    ->shouldReturn(true);
    }

    function it_matches_a_WebHook_by_name(WebHook $command)
    {
        $command->get('command')->willReturn('foo:');

        $this
            ->setCommandName('foo:')
                ->matches($command)
                    ->shouldReturn(true);
    }

    function it_does_not_match_unmatched_names(SlashCommand $command)
    {
        $command->get('command')->willReturn('/bar');

        $this
            ->setCommandName('bar:')
                ->matches($command)
                    ->shouldReturn(false);
    }
}
