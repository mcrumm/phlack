<?php

namespace spec\Crummy\Phlack\Hook;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SlashCommandSpec extends ObjectBehavior
{
    protected $defaultFields = [
        'token'        => '',
        'team_id'      => '',
        'channel_id'   => '',
        'channel_name' => '',
        'user_id'      => '',
        'user_name'    => '',
        'command'      => '',
        'text'         => ''
    ];

    protected $postBackup;
    protected $getBackup;

    function let()
    {
        $this->postBackup = $_POST;
        $_POST            = $this->defaultFields;
        $_POST['token']   = 'POST';

        $this->getBackup  = $_GET;
        $_GET             = $this->defaultFields;
        $_GET['token']    = 'GET';

        $this->beConstructedWith([ ]);
    }

    function it_is_a_hook()
    {
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\Hook\Hook');
    }

    function it_defaults_to_post_global()
    {
        $this::createFromGlobal()->toArray()->shouldReturn([ 'token' => 'POST' ] + $this->defaultFields);
    }

    function it_can_use_get_global_too()
    {
        $this::createFromGlobal(true)->toArray()->shouldReturn([ 'token' => 'GET' ] + $this->defaultFields);
    }

    function it_throws_an_exception_if_missing_required_fields()
    {
        $original = $_POST;
        unset($_POST['command']);
        $this->shouldThrow()->during('createFromGlobal');
        $_POST = $original;
    }

    function it_requires_slash_command_fields()
    {
        $this->getRequiredFields()->shouldReturn(array_keys($this->defaultFields));
    }

    public function letgo()
    {
        $_GET  = $this->getBackup;
        $_POST = $this->postBackup;
    }
}
