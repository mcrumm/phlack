<?php

namespace spec\Crummy\Phlack\Common;

use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Message\MessageInterface;
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
            ->emote('welcomes you')
            ->get('text')
            ->shouldReturn('/me welcomes you')
        ;
    }

    function it_tells_bob_he_is_great()
    {
        $this
            ->tell('bob', 'You rock, sir!')
            ->get('text')
            ->shouldReturn('/msg bob You rock, sir!')
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
