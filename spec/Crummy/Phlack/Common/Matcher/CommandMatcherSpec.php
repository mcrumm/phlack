<?php

namespace spec\Crummy\Phlack\Common\Matcher;

use Crummy\Phlack\WebHook\SlashCommand;
use Crummy\Phlack\WebHook\WebHookInterface;
use PhpSpec\ObjectBehavior;

class CommandMatcherSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(null);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Matcher\CommandMatcher');
    }

    function it_matches_slash_commands(SlashCommand $command)
    {
        $this->matches($command)->shouldReturn(true);
    }

    function it_does_not_match_webhooks(WebHookInterface $webhook)
    {
        $this->matches($webhook)->shouldReturn(false);
    }

    function it_matches_command_by_name(SlashCommand $command)
    {
        $command->get('command')->willReturn('/foo');
        $this->setCommandName('/foo')->matches($command)->shouldReturn(true);
    }

    function it_does_not_match_unmatched_names(SlashCommand $command)
    {
        $command->get('command')->willReturn('/bar');
        $this->setCommandName('/foo')->matches($command)->shouldReturn(false);
    }
}
