<?php

namespace spec\Crummy\Phlack\Common;

use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Message\MessageInterface;
use Crummy\Phlack\WebHook\CommandInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IterocitorSpec extends ObjectBehavior
{
    function let(PhlackClient $client)
    {
        $this->beConstructedWith($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Iterocitor');
        $this->shouldImplement('\Crummy\Phlack\Common\Responder\ResponderInterface');
    }

    function it_says_hello()
    {
        $this
            ->say('Hello!')
            ->get('text')
            ->shouldReturn('Hello!')
        ;
    }

    function it_emotes_a_welcome()
    {
        $this
            ->emote('Welcome!')
            ->get('text')
            ->shouldReturn('<!channel> Welcome!')
        ;
    }

    function it_tells_U12345_he_is_great()
    {
        $this
            ->tell('U12345', 'You rock, sir!')
            ->get('text')
            ->shouldReturn('<@U12345> You rock, sir!')
        ;
    }

    function it_replies_to_carol(CommandInterface $command)
    {
        $command->offsetGet('user_id')->willReturn('U12346');
        $command->offsetGet('user_name')->willReturn('carol');
        $this
            ->reply($command, 'I got your message.')
            ->get('text')
            ->shouldReturn('<@U12346|carol> I got your message.')
        ;
    }

    function it_returns_an_empty_reply_on_send(MessageInterface $message)
    {
        $message->jsonSerialize()->willReturn([ 'text' => 'ok' ]);

        $this
            ->send($message)
                ->get('text')
                    ->shouldReturn('')
        ;
    }
}
