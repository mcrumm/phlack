<?php

namespace spec\Crummy\Phlack;

use Crummy\Phlack\Bridge\Guzzle\Response\MessageResponse;
use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Message\Message;
use Crummy\Phlack\Phlack;
use Guzzle\Service\Command\OperationCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PhlackSpec extends ObjectBehavior
{
    function let(PhlackClient $client)
    {
        $this->beConstructedWith($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Phlack');
    }

    function its_factory_accepts_the_client_config()
    {
        $this::factory(['username' => 'user', 'token' => 'token' ])
            ->shouldReturnAnInstanceOf('\Crummy\Phlack\Phlack');
    }

    function it_sends_messages($client, Message $message, OperationCommand $command, MessageResponse $response)
    {
        $message->jsonSerialize()->willReturn([ ]);

        $client->getCommand(Phlack::MESSAGE_COMMAND, [ ])->willReturn($command);
        $client->execute($command)->willReturn($response);

        $this->send($message)->shouldReturn($response);
    }

    function it_returns_its_client($client)
    {
        $this->getClient()->shouldReturn($client);
    }

    function it_returns_a_message_builder()
    {
        $this->getMessageBuilder()->shouldReturnAnInstanceOf('\Crummy\Phlack\Builder\MessageBuilder');
    }

    function it_returns_an_attachment_builder()
    {
        $this->getAttachmentBuilder()->shouldReturnAnInstanceOf('\Crummy\Phlack\Builder\AttachmentBuilder');
    }

    function it_can_be_statically_created()
    {
        $this::create([ 'username' => 'foo', 'token' => 'bar' ])->shouldReturnAnInstanceOf($this);
    }
}
