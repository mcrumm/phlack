<?php

namespace spec\Crummy\Phlack;

use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Message\Message;
use Crummy\Phlack\Phlack;
use Guzzle\Http\Message\Response;
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

    function it_sends_messages($client, Message $message, OperationCommand $command, Response $response)
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
}
