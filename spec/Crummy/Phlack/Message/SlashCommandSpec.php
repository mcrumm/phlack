<?php

namespace spec\Crummy\Phlack\Message;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SlashCommandSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([ ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Message\SlashCommand');
    }

    function it_is_encodable()
    {
        $this->shouldImplement('\Crummy\Phlack\Common\Encodable');
    }

    function it_is_created_from_global()
    {
        $this::createFromGlobal('POST')->shouldReturnAnInstanceOf($this);
        $this::createFromGlobal('GET')->shouldReturnAnInstanceOf($this);
        $this::createFromGlobal('post')->shouldReturnAnInstanceOf($this);
        $this::createFromGlobal('get')->shouldReturnAnInstanceOf($this);
        $this->shouldThrow('\InvalidArgumentException')->during('createFromGlobal', array('foo'));
    }

    function it_provides_a_fluent_interface()
    {
        $this->setToken('token')->getToken()->shouldReturn('token');
        $this->setTeamId('team_id')->getTeamId()->shouldReturn('team_id');
        $this->setChannelId('channel_id')->getChannelId()->shouldReturn('channel_id');
        $this->setChannelName('channel_name')->getChannelName()->shouldReturn('channel_name');
        $this->setUserId('user_id')->getUserId()->shouldReturn('user_id');
        $this->setUserName('user_name')->getUserName()->shouldReturn('user_name');
        $this->setCommand('/foo')->getCommand()->shouldReturn('/foo');
        $this->setText('bar')->getText()->shouldReturn('bar');
    }
}
