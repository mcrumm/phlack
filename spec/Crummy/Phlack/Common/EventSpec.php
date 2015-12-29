<?php

namespace spec\Crummy\Phlack\Common;

use PhpSpec\ObjectBehavior;

class EventSpec extends ObjectBehavior
{
    public function it_is_an_event()
    {
        $this->shouldBeAnInstanceOf('\Guzzle\Common\Event');
    }
}
