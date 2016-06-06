<?php

namespace spec\Crummy\Phlack\WebHook\Matcher;

use Crummy\Phlack\WebHook\Command;
use PhpSpec\ObjectBehavior;

class DefaultMatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\WebHook\Matcher\DefaultMatcher');
    }

    function it_matches_all_commands(Command $command)
    {
        $this->matches($command)->shouldReturn(true);
    }
}
