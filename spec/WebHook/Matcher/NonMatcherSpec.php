<?php

namespace spec\Crummy\Phlack\WebHook\Matcher;

use Crummy\Phlack\WebHook\Command;
use PhpSpec\ObjectBehavior;

class NonMatcherSpec extends ObjectBehavior
{
    function it_is_a_matcher()
    {
        $this->shouldHaveType('Crummy\Phlack\WebHook\Matcher\NonMatcher');
        $this->shouldImplement('\Crummy\Phlack\WebHook\Matcher\MatcherInterface');
    }

    function it_matches_no_commands(Command $command)
    {
        $this->matches($command)->shouldReturn(false);
    }
}
