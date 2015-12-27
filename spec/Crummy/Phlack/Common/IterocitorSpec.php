<?php

namespace spec\Crummy\Phlack\Common;

use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Message\MessageInterface;
use Crummy\Phlack\WebHook\CommandInterface;
use PhpSpec\ObjectBehavior;

class IterocitorSpec extends ObjectBehavior
{
    public function let(PhlackClient $client)
    {
        $this->beConstructedWith($client);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Iterocitor');
        $this->shouldImplement('\Crummy\Phlack\Common\Responder\ResponderInterface');
    }

    public function it_says_hello()
    {
        $this
            ->say('Hello!')['text']
                ->shouldReturn('Hello!');
    }

    public function it_emotes_a_welcome()
    {
        $this
            ->emote('Welcome!')['text']
                ->shouldReturn('<!channel> Welcome!');
    }

    public function it_shouts_at_everyone()
    {
        $this
            ->shout('Fire!!')['text']
                ->shouldReturn('<!everyone> Fire!!');
    }

    public function it_tells_U12345_he_is_great()
    {
        $this
            ->tell('U12345', 'You rock, sir!')
            ->get('text')
            ->shouldReturn('<@U12345> You rock, sir!');
    }

    public function it_replies_to_carol(CommandInterface $command)
    {
        $command->offsetGet('channel_id')->willReturn('C98765');
        $command->offsetGet('channel_name')->willReturn('group');
        $command->offsetGet('user_id')->willReturn('U12346');
        $command->offsetGet('user_name')->willReturn('carol');
        $this
            ->reply($command, 'I got your message.')['text']
                    ->shouldReturn('<@U12346|carol> I got your message.');
    }

    public function it_proxies_reply_to_tell_for_string_input()
    {
        $this
            ->reply('U12A34C6', 'I got your message.')['text']
                ->shouldReturn('<@U12A34C6> I got your message.');
    }

    public function it_returns_an_empty_reply_on_send(MessageInterface $message)
    {
        $message->jsonSerialize()->willReturn(['text' => 'ok']);

        $this
            ->send($message)['text']
                ->shouldReturn('');
    }
}
