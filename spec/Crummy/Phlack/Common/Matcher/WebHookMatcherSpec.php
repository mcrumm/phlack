<?php

namespace spec\Crummy\Phlack\Common\Matcher;

use Crummy\Phlack\WebHook\WebHookInterface;
use Crummy\Phlack\WebHook\SlashCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WebHookMatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Matcher\WebHookMatcher');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\Common\Matcher\CommandMatcher');
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
