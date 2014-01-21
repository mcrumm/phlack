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

    function its_factory_which_requires_a_config()
    {
        $this::factory([ 'username' => 'foo', 'token' => 'bar' ])->shouldReturnAnInstanceOf($this);
    }

    function its_factory_requires_a_username()
    {
        $this->shouldThrow()->during('factory', array('foo' => 'user', 'token' => 'abc123'));
    }

    function its_factory_requires_a_token()
    {
        $this->shouldThrow()->during('factory', array('username' => 'bar'));
    }
}
