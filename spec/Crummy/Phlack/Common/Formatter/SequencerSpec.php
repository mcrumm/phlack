<?php

namespace spec\Crummy\Phlack\Common\Formatter;

use Crummy\Phlack\WebHook\CommandInterface;
use PhpSpec\ObjectBehavior;

class SequencerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Formatter\Sequencer');
        $this->shouldImplement('Crummy\Phlack\Common\Formatter\FormatterInterface');
    }

    public function it_formats_text()
    {
        $this
            ->format('@U12345')
                ->shouldReturn('<@U12345>');
    }

    public function it_sequences_a_command(CommandInterface $command)
    {
        $command->offsetGet('user_id')->willReturn('U8686');
        $command->offsetGet('user_name')->willReturn('agent');
        $command->offsetGet('channel_id')->willReturn('C0001');
        $command->offsetGet('channel_name')->willReturn('cone');

        $this
            ->command($command)
                ->shouldReturn([
                    'channel'   => '<#C0001|cone>',
                    'user'      => '<@U8686|agent>',
                ]);
    }

    public function it_sequences_an_alert()
    {
        $this
            ->alert('everybody')
                ->shouldReturn('<!everybody>');
    }
}
