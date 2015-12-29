<?php

namespace spec\Crummy\Phlack\Bridge\Symfony\HttpKernel;

use Crummy\Phlack\Bot\Mainframe\Mainframe;
use Crummy\Phlack\Bridge\Symfony\HttpFoundation\RequestConverter;
use Crummy\Phlack\WebHook\SlashCommand;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;

class MainframeKernelSpec extends ObjectBehavior
{
    public function let(Mainframe $mainframe, RequestConverter $converter)
    {
        $this->beConstructedWith($mainframe, $converter);
    }

    public function it_an_HttpKernelInterface_adapter()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Symfony\HttpKernel\MainframeKernel');
        $this->shouldImplement('\Crummy\Phlack\Bot\Mainframe\Adapter\AdapterInterface');
        $this->shouldBeAnInstanceOf('\Symfony\Component\HttpKernel\HttpKernelInterface');
    }

    public function it_handles_a_request_and_emits_a_response($mainframe, $converter, Request $request, SlashCommand $cmd)
    {
        $converter->convert($request)->willReturn($cmd);
        $mainframe->execute($cmd)->shouldBeCalled();
        $this->handle($request)->shouldReturnAnInstanceOf('\Symfony\Component\HttpFoundation\Response');
    }
}
