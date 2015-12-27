<?php

namespace spec\Crummy\Phlack\Bridge\Guzzle;

use Guzzle\Common\Event;
use Guzzle\Service\Command\CommandInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ApiClientSpec extends ObjectBehavior
{
    protected $config = ['token' => 'foo'];

    public function let()
    {
        $this->beConstructedWith($this->config);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Guzzle\ApiClient');
    }

    public function it_has_a_factory_method()
    {
        $this::factory($this->config)->shouldReturnAnInstanceOf($this);
    }

    public function it_adds_the_token_to_the_command_before_prepare(Event $event, CommandInterface $command)
    {
        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->getEventDispatcher();

        $event->offsetGet('command')->willReturn($command);
        $event->setDispatcher($dispatcher)->shouldBeCalled();
        $event->setName('command.before_prepare')->shouldBeCalled();
        $event->isPropagationStopped()->willReturn(false);
        $command->offsetSet('token', $this->config['token'])->shouldBeCalled();

        $dispatcher->dispatch('command.before_prepare', $event);
    }
}
