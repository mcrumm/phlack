<?php

namespace spec\Crummy\Phlack\Common\Matcher;

use Crummy\Phlack\WebHook\CommandInterface;
use PhpSpec\ObjectBehavior;

class NonMatcherSpec extends ObjectBehavior
{
    public function it_is_a_matcher()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Matcher\NonMatcher');
        $this->shouldImplement('\Crummy\Phlack\Common\Matcher\MatcherInterface');
    }

    public function it_matches_no_commands(CommandInterface $command)
    {
        $this->matches($command)->shouldReturn(false);
    }
}
