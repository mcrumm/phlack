<?php

namespace spec\Crummy\Phlack\WebHook\Matcher;

use Crummy\Phlack\WebHook\SlashCommand;
use Crummy\Phlack\WebHook\WebHookInterface;
use PhpSpec\ObjectBehavior;

class WebHookMatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\WebHook\Matcher\WebHookMatcher');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\WebHook\Matcher\CommandNameMatcher');
    }

    function it_matches_webhooks(WebHookInterface $webhook)
    {
        $this->matches($webhook)->shouldReturn(true);
    }

    function it_does_not_match_slash_commands(SlashCommand $command)
    {
        $this->matches($command)->shouldReturn(false);
    }
}
