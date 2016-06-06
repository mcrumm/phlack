<?php

namespace spec\Crummy\Phlack\WebHook\Matcher;

use Crummy\Phlack\WebHook\Command;
use PhpSpec\ObjectBehavior;

class CommandMatcherSpec extends ObjectBehavior
{
    function it_is_a_matcher()
    {
        $this->shouldImplement('\Crummy\Phlack\WebHook\Matcher\MatcherInterface');
    }

    function it_matches_a_command_by_name()
    {
        $this->beConstructedWith('/foo');

        $this
            ->matches(new Command(['command' => '/foo']))
            ->shouldBe(true)
        ;
    }

    function it_does_not_match_unmatched_names()
    {
        $this->beConstructedWith('/foo');

        $this
            ->matches(new Command(['command' => '/bar']))
            ->shouldBe(false)
        ;
    }

    function it_does_not_match_non_commands()
    {
        $this->matches(new Command())->shouldBe(false);
    }
}
