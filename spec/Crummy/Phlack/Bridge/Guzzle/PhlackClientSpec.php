<?php

namespace spec\Crummy\Phlack\Bridge\Guzzle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PhlackClientSpec extends ObjectBehavior
{
    static $mockUrl    = 'https://hooks.slack.com/services/AAAA/BBBB/CCCC';
    static $mockConfig = [ 'username' => 'foo', 'token' => 'bar' ];

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Guzzle\PhlackClient');
    }

    function it_is_a_guzzle_client()
    {
        $this->shouldHaveType('\Guzzle\Service\Client');
    }

    function its_factory_accepts_a_custom_base_url()
    {
        $this->beConstructedThrough('factory', [
            [ 'url' => self::$mockUrl ]
        ]);

        $this->getBaseUrl()->shouldBe(self::$mockUrl);
    }

    function it_accepts_a_config_hash_through_factory()
    {
        $this->beConstructedThrough('factory', [ self::$mockConfig ]);

        $this->getDescription()->shouldBeAnInstanceOf('Guzzle\Service\Description\ServiceDescription');
    }

    function its_factory_accepts_a_single_argument_for_url()
    {
        $this->beConstructedThrough('factory', [ self::$mockUrl ]);

        $this->getBaseUrl()->shouldBe(self::$mockUrl);
    }

    function its_factory_requires_a_username()
    {
        $this->beConstructedThrough('factory', [
            [ 'foo' => 'user', 'token' => 'abc123' ]
        ]);

        $this->shouldThrow()->duringInstantiation();
    }

    function its_factory_requires_a_token()
    {
        $this->beConstructedThrough('factory', [
            [ 'username' => 'mr.no_token' ]
        ]);

        $this->shouldThrow()->duringInstantiation();
    }

    function it_attaches_a_listener_in_legacy_mode()
    {
        $this->beConstructedThrough('factory', [ self::$mockConfig ]);

        // Redirect plugin + LegacyUrlPlugin = 2 request.before_send plugins.
        $this->getEventDispatcher()->getListeners('request.before_send')->shouldHaveCount(2);
    }
}
