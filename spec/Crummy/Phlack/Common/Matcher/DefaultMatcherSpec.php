<?php

namespace spec\Crummy\Phlack\Common\Matcher;

use Crummy\Phlack\WebHook\CommandInterface;
use PhpSpec\ObjectBehavior;

class DefaultMatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Matcher\DefaultMatcher');
    }

    function it_matches_all_commands(CommandInterface $command)
    {
        $this->matches($command)->shouldReturn(true);
    }
}
