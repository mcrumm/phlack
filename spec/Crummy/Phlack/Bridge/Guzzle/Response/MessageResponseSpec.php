<?php

namespace spec\Crummy\Phlack\Bridge\Guzzle\Response;

use Guzzle\Http\Message\Response;
use Guzzle\Service\Command\OperationCommand;
use PhpSpec\ObjectBehavior;

class MessageResponseSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith([
            'status' => '200',
            'reason' => 'OK',
            'text'   => '',
        ]);
    }

    public function it_is_a_response_class()
    {
        $this->shouldImplement('\Guzzle\Service\Command\ResponseClassInterface');
    }

    public function it_is_create_from_command(OperationCommand $command)
    {
        $command->getResponse()->willReturn(new Response('404', '', ''));

        $this::fromCommand($command)->shouldReturnAnInstanceOf($this);
    }
}
