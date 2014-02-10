<?php

namespace spec\Crummy\Phlack\Common\Matcher;

use Crummy\Phlack\WebHook\CommandInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NonMatcherSpec extends ObjectBehavior
{
    function it_is_a_matcher()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Matcher\NonMatcher');
        $this->shouldImplement('\Crummy\Phlack\Common\Matcher\MatcherInterface');
    }

    function it_matches_no_commands(CommandInterface $command)
    {
        $this->matches($command)->shouldReturn(false);
    }
}
