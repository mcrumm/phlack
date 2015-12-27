<?php

namespace spec\Crummy\Phlack\WebHook;

use PhpSpec\ObjectBehavior;

class WebHookSpec extends ObjectBehavior
{
    protected $defaultFields = [
        'token'        => '',
        'team_id'      => '',
        'team_domain'  => '',
        'service_id'   => '',
        'channel_id'   => '',
        'channel_name' => '',
        'timestamp'    => 1391368865.000002,
        'user_id'      => '',
        'user_name'    => '',
        'text'         => '',
    ];

    protected $postBackup;

    public function let()
    {
        $this->postBackup = $_POST;
        $_POST = $this->defaultFields;
        $_POST['token'] = 'POST';

        $this->beConstructedWith($this->defaultFields);
    }

    public function it_is_a_webhook_command()
    {
        $this->shouldHaveType('Crummy\Phlack\WebHook\WebHook');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\WebHook\AbstractCommand');
        $this->shouldImplement('\Crummy\Phlack\WebHook\WebHookInterface');
    }

    public function it_will_fail_on_fromGet()
    {
        $this
            ->shouldThrow('\Crummy\Phlack\Common\Exception\RuntimeException')
                ->during('fromGet');
    }

    public function its_command_is_delimited_with_a_colon()
    {
        $commands = [
            'hello:' => 'hello: world',
            'echo:'  => 'echo: foo',
            'foo:'   => 'foo: bar',
        ];

        $postBackup = $_POST;
        foreach ($commands as $command => $text) {
            $_POST = ['text' => $text] + $postBackup;
            $this::fromPost()->getCommand()->shouldReturn($command);
        }
        $_POST = $postBackup;
    }

    public function it_normalizes_commands_without_a_delimiter()
    {
        $commands = [
            'hello:' => 'hello world',
            'echo:'  => 'echo foo',
            'foo:'   => 'foo bar',
            'where:' => 'Where in the world is Carmen San Diego?',
            'where:' => 'WhErE cAn I gEt A dRiNk?',
            'wtf:'   => 'WTF',
            'wtf:'   => 'WTF?!?!?!?!',
        ];

        $postBackup = $_POST;
        foreach ($commands as $command => $text) {
            $_POST = ['text' => $text] + $postBackup;
            $this::fromPost()->getCommand()->shouldReturn($command);
        }
        $_POST = $postBackup;
    }

    public function letgo()
    {
        $_POST = $this->postBackup;
    }
}
