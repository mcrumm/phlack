<?php

namespace spec\Crummy\Phlack\WebHook;

use PhpSpec\ObjectBehavior;

class WebHookSpec extends ObjectBehavior
{
    protected $defaultFields = [
        'token'        => 'phlack_spec_token',
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

    public function let()
    {
        $this->beConstructedWith($this->defaultFields);
    }

    public function it_is_a_webhook_command()
    {
        $this->shouldHaveType('Crummy\Phlack\WebHook\WebHook');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\WebHook\AbstractCommand');
        $this->shouldImplement('\Crummy\Phlack\WebHook\WebHookInterface');
    }

    public function it_can_be_created_fromConfig()
    {
        $config = ['team_domain' => 'http://phlack.slack.com'] + $this->defaultFields;
        $this->beConstructedThrough('fromConfig', [$config]);

        $this->toArray()->shouldHaveKeyWithValue('team_domain', 'http://phlack.slack.com');
    }

    /**
     *  @dataProvider commandExamples
     */
    public function its_command_is_delimited_with_a_colon($input, $expected)
    {
        $config = ['text' => $input] + $this->defaultFields;

        $this->beConstructedWith($config);

        $this['command']->shouldBe($expected);
    }

    /**
     *  @dataProvider textExamples
     */
    public function it_normalizes_commands_without_a_delimiter($input, $expected)
    {
        $config = ['text' => $input] + $this->defaultFields;

        $this->beConstructedWith($config);

        $this['command']->shouldBe($expected);
    }

    public function commandExamples()
    {
        return [
            ['hello: world', 'hello:'],
            ['echo: foo', 'echo:'],
            ['foo: bar', 'foo:'],
        ];
    }

    public function textExamples()
    {
        return [
            ['hello world', 'hello:'],
            ['echo foo', 'echo:'],
            ['foo bar', 'foo:'],
            ['Where in the world is Carmen San Diego?', 'where:'],
            ['WhErE cAn I gEt A dRiNk?', 'where:'],
            ['WTF', 'wtf:'],
            ['WTF?!?!?!?!', 'wtf:'],
        ];
    }
}
