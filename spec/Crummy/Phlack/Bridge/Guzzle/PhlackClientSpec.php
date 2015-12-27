<?php

namespace spec\Crummy\Phlack\Bridge\Guzzle;

use PhpSpec\ObjectBehavior;

class PhlackClientSpec extends ObjectBehavior
{
    public static $mockUrl = 'https://hooks.slack.com/services/AAAA/BBBB/CCCC';
    public static $mockConfig = ['username' => 'foo', 'token' => 'bar'];

    public function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Guzzle\PhlackClient');
    }

    public function it_is_a_guzzle_client()
    {
        $this->shouldHaveType('\Guzzle\Service\Client');
    }

    public function its_factory_accepts_a_custom_base_url()
    {
        $this->beConstructedThrough('factory', [
            ['url' => self::$mockUrl],
        ]);

        $this->getBaseUrl()->shouldBe(self::$mockUrl);
    }

    public function it_accepts_a_config_hash_through_factory()
    {
        $this->beConstructedThrough('factory', [self::$mockConfig]);

        $this->getDescription()->shouldBeAnInstanceOf('Guzzle\Service\Description\ServiceDescription');
    }

    public function its_factory_accepts_a_single_argument_for_url()
    {
        $this->beConstructedThrough('factory', [self::$mockUrl]);

        $this->getBaseUrl()->shouldBe(self::$mockUrl);
    }

    public function its_factory_requires_a_username()
    {
        $this->beConstructedThrough('factory', [
            ['foo' => 'user', 'token' => 'abc123'],
        ]);

        $this->shouldThrow()->duringInstantiation();
    }

    public function its_factory_requires_a_token()
    {
        $this->beConstructedThrough('factory', [
            ['username' => 'mr.no_token'],
        ]);

        $this->shouldThrow()->duringInstantiation();
    }

    public function it_attaches_a_listener_in_legacy_mode()
    {
        $this->beConstructedThrough('factory', [self::$mockConfig]);

        // Redirect plugin + LegacyUrlPlugin = 2 request.before_send plugins.
        $this->getEventDispatcher()->getListeners('request.before_send')->shouldHaveCount(2);
    }
}
