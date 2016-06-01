<?php

namespace spec\Crummy\Phlack\Common;

use PhpSpec\ObjectBehavior;

class EventSpec extends ObjectBehavior
{
    function it_is_an_event()
    {
        $this->shouldBeAnInstanceOf('\Guzzle\Common\Event');
    }
}
