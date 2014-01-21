<?php

namespace spec\Crummy\Phlack\Bridge\Guzzle;

use Guzzle\Service\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PhlackClientSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Guzzle\PhlackClient');
    }

    function it_is_a_guzzle_client()
    {
        $this->shouldHaveType('\Guzzle\Service\Client');
    }
}
