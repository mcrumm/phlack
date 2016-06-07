<?php

namespace spec\Crummy\Phlack\WebHook;

use Crummy\Phlack\WebHook\Executable;
use Crummy\Phlack\WebHook\Matcher\DefaultMatcher;
use PhpSpec\ObjectBehavior;

class MainframeSpec extends ObjectBehavior
{
    function it_is_an_executable()
    {
        $this->shouldHaveType('Crummy\Phlack\WebHook\Mainframe');
        $this->shouldImplement('\Crummy\Phlack\WebHook\Executable');
    }

    function it_fluently_attaches_bots_and_matchers(Executable $assistant, DefaultMatcher $matcher)
    {
        $this->attach($assistant, $matcher)->shouldReturn($this);
    }
}
