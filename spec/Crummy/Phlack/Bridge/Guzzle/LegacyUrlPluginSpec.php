<?php

namespace spec\Crummy\Phlack\Bridge\Guzzle;

use Crummy\Phlack\Bridge\Guzzle\LegacyUrlPlugin;
use Guzzle\Common\Event;
use Guzzle\Http\Message\Request;
use Guzzle\Http\QueryString;
use Guzzle\Http\Url;
use PhpSpec\ObjectBehavior;

class LegacyUrlPluginSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('username', 'token');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Guzzle\LegacyUrlPlugin');
    }

    public function it_is_an_event_subscriber()
    {
        $this->shouldImplement('\Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    public function it_subscribes_to_guzzle_events()
    {
        $this->getSubscribedEvents()->shouldHaveKey('request.before_send');
    }

    public function it_dispatches_before_send(Event $e, Request $request, Url $url, QueryString $q)
    {
        $e->offsetGet('request')->willReturn($request);
        $request->getUrl(true)->willReturn($url);
        $url->setHost(sprintf(LegacyUrlPlugin::BASE_URL, 'username'))->willReturn($url);
        $url->setPath(LegacyUrlPlugin::WEBHOOK_PATH)->willReturn($url);
        $url->setScheme('https')->willReturn($url);
        $request->setUrl($url)->shouldBeCalled()->willReturn($request);
        $request->getQuery()->shouldBeCalled()->willReturn($q);

        $this->onRequestBeforeSend($e)->shouldReturn(null);
    }
}
