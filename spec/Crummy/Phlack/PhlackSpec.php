<?php

namespace spec\Crummy\Phlack;

use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Bridge\Guzzle\Response\MessageResponse;
use Crummy\Phlack\Message\Message;
use Guzzle\Service\Client;
use Guzzle\Service\Command\OperationCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PhlackSpec extends ObjectBehavior
{
    public static $mockUrl = 'https://hooks.slack.com/services/XXXXXXX/YYYYYYY/ZZZZZZZ';
    public static $mockConfig = ['username' => 'user', 'token' => 'token'];

    public function let(PhlackClient $client, OperationCommand $command, MessageResponse $response)
    {
        $client->execute($command)->willReturn($response);

        $command->execute()->willReturn($response);

        $this->beConstructedWith($client);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Phlack');
    }

    public function it_assumes_it_received_a_client_config_fromConfig()
    {
        $this->beConstructedThrough('fromConfig', [['url' => self::$mockUrl]]);

        $this->getClient()->shouldReturnAnInstanceOf('Crummy\Phlack\Bridge\Guzzle\PhlackClient');
    }

    public function it_assumes_it_received_a_url_when_constructed_with_a_string()
    {
        $this->beConstructedWith(self::$mockUrl);

        $this->getClient()->shouldReturnAnInstanceOf('Crummy\Phlack\Bridge\Guzzle\PhlackClient');
    }

    public function it_assumes_it_received_a_client_config_when_constructed_with_an_array()
    {
        $this->beConstructedWith(self::$mockConfig);

        $this->getClient()->shouldReturnAnInstanceOf('Crummy\Phlack\Bridge\Guzzle\PhlackClient');
    }

    public function it_fails_to_instantiate_with_an_invalid_client(Client $client)
    {
        $this->shouldThrow('\InvalidArgumentException')
            ->during('__construct', [$client]);
    }

    public function it_assumes_url_when_factory_gets_a_single_argument()
    {
        $this::beConstructedThrough('factory', [self::$mockUrl]);

        $this->getClient()->getBaseUrl()->shouldBe(self::$mockUrl);
    }

    public function its_factory_accepts_the_client_config()
    {
        $this->beConstructedThrough('factory', [self::$mockConfig]);

        $this->getClient()->shouldReturnAnInstanceOf('Crummy\Phlack\Bridge\Guzzle\PhlackClient');
    }

    public function it_sends_a_string_message($client, OperationCommand $command, MessageResponse $response)
    {
        $client
            ->getCommand('Send', Argument::withEntry('text', 'Hello'))
            ->shouldBeCalled()
            ->willReturn($command);

        $this->send('Hello')->shouldReturn($response);
    }

    public function it_sends_an_array_of_message_parameters($client, OperationCommand $command, MessageResponse $response)
    {
        $message = [
            'text'       => 'Howdy!',
            'username'   => 'incoming-webhook',
            'channel'    => '#random',
        ];

        $client
            ->getCommand('Send', $message)
            ->shouldBeCalled()
            ->willReturn($command);

        $this->send($message)->shouldReturn($response);
    }

    public function it_sends_any_JsonSerializable_that_returns_an_array($client, \JsonSerializable $message, OperationCommand $command, MessageResponse $response)
    {
        $message->jsonSerialize()->willReturn([]);

        $client->getCommand('Send', [])->willReturn($command);

        $this->send($message)->shouldReturn($response);
    }

    public function it_fails_to_send_nonsense($client, \Iterator $iterator)
    {
        $this->shouldThrow('\InvalidArgumentException')
            ->during('send', [$iterator]);
    }

    public function it_sends_messages($client, Message $message, OperationCommand $command, MessageResponse $response)
    {
        $message->jsonSerialize()->willReturn([]);

        $client->getCommand('Send', [])->willReturn($command);
        $client->execute($command)->willReturn($response);

        $this->send($message)->shouldReturn($response);
    }

    public function it_returns_its_client($client)
    {
        $this->getClient()->shouldReturn($client);
    }

    public function it_returns_a_message_builder()
    {
        $this->getMessageBuilder()->shouldReturnAnInstanceOf('\Crummy\Phlack\Builder\MessageBuilder');
    }

    public function it_returns_an_attachment_builder()
    {
        $this->getAttachmentBuilder()->shouldReturnAnInstanceOf('\Crummy\Phlack\Builder\AttachmentBuilder');
    }
}
