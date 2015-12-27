<?php

namespace spec\Crummy\Phlack\WebHook;

use PhpSpec\ObjectBehavior;

class SlashCommandSpec extends ObjectBehavior
{
    protected $defaultFields = [
        'token'        => '',
        'team_id'      => '',
        'team_domain'  => '',
        'service_id'   => '',
        'channel_id'   => '',
        'channel_name' => '',
        'user_id'      => '',
        'user_name'    => '',
        'command'      => '',
        'text'         => '',
    ];

    protected $postBackup;
    protected $getBackup;

    public function let()
    {
        $this->postBackup = $_POST;
        $_POST = $this->defaultFields;
        $_POST['token'] = 'POST';

        $this->getBackup = $_GET;
        $_GET = $this->defaultFields;
        $_GET['token'] = 'GET';

        $this->beConstructedWith($this->defaultFields);
    }

    public function it_is_a_webhook_command()
    {
        $this->shouldHaveType('Crummy\Phlack\WebHook\SlashCommand');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\WebHook\AbstractCommand');
        $this->shouldImplement('\Crummy\Phlack\WebHook\CommandInterface');
        $this->shouldImplement('\Crummy\Phlack\Common\Encodable');
    }

    public function it_defaults_to_post_global()
    {
        $this::fromPost()->toArray()->shouldReturn(['token' => 'POST'] + $this->defaultFields);
    }

    public function it_can_use_get_global_too()
    {
        $this::fromGet()->toArray()->shouldReturn(['token' => 'GET'] + $this->defaultFields);
    }

    public function letgo()
    {
        $_GET = $this->getBackup;
        $_POST = $this->postBackup;
    }
}
