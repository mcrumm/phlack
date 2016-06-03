<?php

namespace spec\Crummy\Phlack\Bridge\Symfony\HttpKernel;

use Crummy\Phlack\Bot\ExpressionBot;
use Crummy\Phlack\WebHook\Mainframe;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;

class MainframeKernelSpec extends ObjectBehavior
{
    function let()
    {
        $mf = new Mainframe();
        $mf->attach(new ExpressionBot('/math'));

        $this->beConstructedWith($mf);
    }

    function it_an_HttpKernelInterface_adapter()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Symfony\HttpKernel\MainframeKernel');
        $this->shouldImplement('\Crummy\Phlack\Bot\Mainframe\Adapter\AdapterInterface');
        $this->shouldBeAnInstanceOf('\Symfony\Component\HttpKernel\HttpKernelInterface');
    }

    function it_turns_a_request_into_a_response()
    {
        $request = new Request([], [
            'token' => 'gIkuvaNzQIHg97ATvDxqgjtO',
            'team_id' => 'T0001',
            'team_domain' => 'example',
            'channel_id' => 'C2147483705',
            'channel_name' =>'test',
            'user_id' => 'U2147483697',
            'user_name' => 'Steve',
            'command' => '/math',
            'text' => '2 - -2',
            'response_url' => 'https://hooks.slack.com/commands/1234/5678'
        ]);

        $this
            ->handle($request)
            ->getContent()
            ->shouldBe(json_encode(['text' => '4']))
        ;
    }
}
