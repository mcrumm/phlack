<?php

namespace spec\Crummy\Phlack\Common\Formatter;

use Crummy\Phlack\Message\Message;
use Crummy\Phlack\WebHook\CommandInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SlackFormatterSpec extends ObjectBehavior
{
    function it_is_a_message_formatter()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Formatter\SlackFormatter');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\Common\Formatter\AbstractFormatter');
    }

    function it_encodes_htmlspecialchars_but_no_quotes(Message $message)
    {
        $message->jsonSerialize()->willReturn([ 'text' => '<foo> & \'bar\'' ]);

        $this
            ->setMessage($message)
                ->jsonSerialize()['text']
                    ->shouldBeLike('&lt;foo&gt; &amp; \'bar\'');
    }

    function it_formats_a_user_string_from_a_command(CommandInterface $command)
    {
        $command->offsetGet('user_id')->willReturn('U12345');
        $command->offsetGet('user_name')->willReturn('bob');
        $this->setMessage($command);
        $this->formatUserString()->shouldReturn('<@U12345|bob>');
    }

    function it_formats_a_channel_string_from_a_command(CommandInterface $command)
    {
        $command->offsetGet('channel_id')->willReturn('C98765');
        $command->offsetGet('channel_name')->willReturn('garage');
        $this->setMessage($command);
        $this->formatChannelString()->shouldReturn('<#C98765|garage>');
    }
}
