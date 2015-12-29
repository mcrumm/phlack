<?php

namespace spec\Crummy\Phlack\WebHook;

use PhpSpec\ObjectBehavior;

class SlashCommandSpec extends ObjectBehavior
{
    protected $defaultFields = [
        'token'        => 'phlack_spec_token',
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

    public function let()
    {
        $this->beConstructedWith($this->defaultFields);
    }

    public function it_is_a_webhook_command()
    {
        $this->shouldHaveType('Crummy\Phlack\WebHook\SlashCommand');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\WebHook\AbstractCommand');
        $this->shouldImplement('\Crummy\Phlack\WebHook\CommandInterface');
        $this->shouldImplement('\Crummy\Phlack\Common\Encodable');
    }

    public function it_can_be_created_fromConfig()
    {
        $config = ['team_domain' => 'http://phlack.slack.com'] + $this->defaultFields;
        $this->beConstructedThrough('fromConfig', [$config]);

        $this->toArray()->shouldReturn($config);
    }
}
