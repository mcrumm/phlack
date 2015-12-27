<?php

namespace spec\Crummy\Phlack\Common\Matcher;

use Crummy\Phlack\WebHook\SlashCommand;
use Crummy\Phlack\WebHook\WebHookInterface;
use PhpSpec\ObjectBehavior;

class WebHookMatcherSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Matcher\WebHookMatcher');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\Common\Matcher\CommandNameMatcher');
    }

    public function it_matches_webhooks(WebHookInterface $webhook)
    {
        $this->matches($webhook)->shouldReturn(true);
    }

    public function it_does_not_match_slash_commands(SlashCommand $command)
    {
        $this->matches($command)->shouldReturn(false);
    }
}
