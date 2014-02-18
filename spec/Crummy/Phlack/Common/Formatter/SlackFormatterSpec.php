<?php

namespace spec\Crummy\Phlack\Common\Formatter;

use Crummy\Phlack\Message\Message;
use Crummy\Phlack\WebHook\CommandInterface;
use Crummy\Phlack\WebHook\Reply\Reply;
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
        $this->formatUserString()->shouldReturn('[@U12345|bob]');
    }

    function it_returns_an_empty_user_string_for_non_commands(Reply $reply)
    {
        $this->setMessage($reply);
        $this->formatUserString()->shouldReturn('');
    }

    function it_formats_a_channel_string_from_a_command(CommandInterface $command)
    {
        $command->offsetGet('channel_id')->willReturn('C98765');
        $command->offsetGet('channel_name')->willReturn('garage');
        $this->setMessage($command);
        $this->formatChannelString()->shouldReturn('[#C98765|garage]');
    }

    function it_returns_an_empty_channel_string_for_non_commands(Reply $reply)
    {
        $this->setMessage($reply);
        $this->formatChannelString()->shouldReturn('');
    }

    function it_correctly_encodes_identifiers(Message $message)
    {
        $message->jsonSerialize()->willReturn([ 'text' => '[@U12345|crumm] <say hi to> [#C01010|botgarage]' ]);
        $this
            ->setMessage($message)
            ->jsonSerialize()['text']
            ->shouldBeLike('<@U12345|crumm> &lt;say hi to&gt; <#C01010|botgarage>');
    }

    function it_correctly_encodes_special_commands(Message $message)
    {
        $message->jsonSerialize()->willReturn([ 'text' => '[!everyone] important meeting in the conference room.' ]);
        $this
            ->setMessage($message)
            ->jsonSerialize()['text']
            ->shouldBeLike('<!everyone> important meeting in the conference room.');
    }

    function it_can_format_text(Message $message)
    {
        $message->offsetExists('text')->willReturn(true);
        $message->offsetGet('text')->willReturn('hello & good morning to you!');
        $this->setMessage($message)->formatText()->shouldBe('hello &amp; good morning to you!');
    }

    function it_returns_an_empty_string_for_messages_with_no_text(Message $message)
    {
        $message->offsetExists('text')->willReturn(false);
        $this->setMessage($message)->formatText()->shouldBe('');
    }

    function it_returns_the_encoded_string_when_cast(Message $message)
    {
        $message->offsetExists('text')->willReturn(true);
        $message->offsetGet('text')->willReturn('<foo>');
        $message->__toString()->willReturn('<foo>');
        $this->setMessage($message)->__toString()->shouldReturn('&lt;foo&gt;');
    }
}
