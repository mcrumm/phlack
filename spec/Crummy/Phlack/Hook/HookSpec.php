<?php

namespace spec\Crummy\Phlack\Hook;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HookSpec extends ObjectBehavior
{
    protected $defaultFields = [
        'token'        => '',
        'team_id'      => '',
        'channel_id'   => '',
        'channel_name' => '',
        'timestamp'    => '',
        'user_id'      => '',
        'user_name'    => '',
        'text'         => ''
    ];

    protected $postBackup;

    function let()
    {
        $this->postBackup = $_POST;
        $_POST            = $this->defaultFields;

        $this->beConstructedWith([ ]);
    }

    function it_is_encodable()
    {
        $this->shouldImplement('\Crummy\Phlack\Common\Encodable');
    }

    function it_is_created_from_global()
    {
        $this::createFromGlobal()->shouldReturnAnInstanceOf('\Crummy\Phlack\Hook\Hook');
    }

    function it_uses_post_global()
    {
        $this::createFromGlobal()->toArray()->shouldBeLike($this->defaultFields);
    }

    function it_throws_an_exception_if_missing_required_fields()
    {
        $original = $_POST;
        unset($_POST['text']);
        $this->shouldThrow()->during('createFromGlobal');
        $_POST = $original;
    }

    function it_requires_outgoing_hook_fields()
    {
         $this->getRequiredFields()->shouldReturn(array_keys($this->defaultFields));
    }

    function letgo()
    {
        $_POST = $this->postBackup;
    }
}
