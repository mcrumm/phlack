<?php

namespace spec\Crummy\Phlack\Bridge\Symfony\HttpFoundation;

use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class RequestConverterSpec extends ObjectBehavior
{
    protected $webhook = [
        'token'        => '',
        'team_id'      => '',
        'team_domain'  => '',
        'service_id'   => '',
        'channel_id'   => '',
        'channel_name' => '',
        'timestamp'    => 1391368865.000002,
        'user_id'      => '',
        'user_name'    => '',
        'text'         => 'hello world',
    ];

    protected $slashCommand = [
        'token'        => '',
        'team_id'      => '',
        'channel_id'   => '',
        'channel_name' => '',
        'user_id'      => '',
        'user_name'    => '',
        'command'      => '/hello',
        'text'         => 'world',
    ];

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Symfony\HttpFoundation\RequestConverter');
        $this->shouldImplement('\Crummy\Phlack\WebHook\Converter\ConverterInterface');
    }

    function it_converts_a_request_into_a_command(Request $request, ParameterBag $post, ParameterBag $get)
    {
        $request->request = $post;
        $request->query = $get;
        $post->all()->willReturn($this->slashCommand);
        $this->convert($request)->shouldReturnAnInstanceOf('\Crummy\Phlack\WebHook\Command');
    }

    function it_can_be_invoked_to_convert_a_request_into_a_command(Request $request, ParameterBag $post, ParameterBag $get)
    {
        $request->request = $post;
        $request->query = $get;
        $post->all()->willReturn($this->slashCommand);
        $this->__invoke($request)->shouldReturnAnInstanceOf('\Crummy\Phlack\WebHook\Command');
    }

    function it_converts_requests_into_an_outgoing_webhook_command(Request $request, ParameterBag $post, ParameterBag $get)
    {
        $request->request = $post;
        $request->query = $get;
        $post->all()->willReturn([]);
        $get->all()->willReturn($this->webhook);
        $this->__invoke($request)->shouldReturnAnInstanceOf('\Crummy\Phlack\WebHook\Command');
    }
}
