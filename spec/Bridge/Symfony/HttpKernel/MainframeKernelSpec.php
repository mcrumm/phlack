<?php

namespace spec\Crummy\Phlack\Bridge\Symfony\HttpKernel;

use Crummy\Phlack\WebHook\Mainframe;
use Crummy\Phlack\WebHook\SlashCommand;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;

class MainframeKernelSpec extends ObjectBehavior
{
    function let(Mainframe $mainframe)
    {
        $this->beConstructedWith($mainframe);
    }

    function it_an_HttpKernelInterface_adapter()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Symfony\HttpKernel\MainframeKernel');
        $this->shouldImplement('\Crummy\Phlack\Bot\Mainframe\Adapter\AdapterInterface');
        $this->shouldBeAnInstanceOf('\Symfony\Component\HttpKernel\HttpKernelInterface');
    }

    function it_turns_a_request_into_a_response($mainframe, Request $request, SlashCommand $cmd)
    {
        $this->beConstructedWith($mainframe, function () use ($cmd) {
            return $cmd->getWrappedObject();
        });

        $mainframe->execute($cmd)->shouldBeCalled();
        $this->handle($request)->shouldReturnAnInstanceOf('\Symfony\Component\HttpFoundation\Response');
    }
}
