<?php

namespace spec\Crummy\Phlack\Common\Formatter;

use Crummy\Phlack\WebHook\Command;
use PhpSpec\ObjectBehavior;

class SequencerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Common\Formatter\Sequencer');
        $this->shouldImplement('Crummy\Phlack\Common\Formatter\FormatterInterface');
    }

    function it_formats_text()
    {
        $this
            ->format('@U12345')
                ->shouldReturn('<@U12345>');
    }

    function it_sequences_a_command()
    {
        $command = new Command([
            'user_id' => 'U8686',
            'user_name' => 'agent',
            'channel_id' => 'C0001',
            'channel_name' => 'cone',
        ]);

        $this
            ->command($command)
            ->shouldReturn([
                'channel'   => '<#C0001|cone>',
                'user'      => '<@U8686|agent>',
            ])
        ;
    }

    function it_sequences_an_alert()
    {
        $this
            ->alert('everybody')
            ->shouldReturn('<!everybody>')
        ;
    }
}
