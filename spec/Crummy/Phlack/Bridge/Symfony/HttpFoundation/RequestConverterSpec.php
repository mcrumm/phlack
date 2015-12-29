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

    public function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Symfony\HttpFoundation\RequestConverter');
        $this->shouldImplement('\Crummy\Phlack\WebHook\Converter\ConverterInterface');
    }

    public function it_converts_requests_into_slash_commands(Request $request, ParameterBag $post, ParameterBag $get)
    {
        $request->request = $post;
        $request->query = $get;
        $post->all()->willReturn($this->slashCommand);
        $this->convert($request)->shouldReturnAnInstanceOf('\Crummy\Phlack\WebHook\SlashCommand');
    }

    public function it_converts_requests_into_webhooks(Request $request, ParameterBag $post, ParameterBag $get)
    {
        $request->request = $post;
        $request->query = $get;
        $post->all()->willReturn([]);
        $get->all()->willReturn($this->webhook);
        $this->convert($request)->shouldReturnAnInstanceOf('\Crummy\Phlack\WebHook\WebHook');
    }

    public function it_throws_an_exception_for_an_invalid_request(Request $request, ParameterBag $post, ParameterBag $get)
    {
        $request->request = $post;
        $request->query = $get;

        $post->all()->willReturn([]);
        $get->all()->willReturn(['text' => 'Hello!']);

        $this->shouldThrow()->during('convert', [$request]);
    }
}
