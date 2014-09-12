<?php

namespace spec\Crummy\Phlack\Bot;

use Crummy\Phlack\Common\Iterocitor;
use Crummy\Phlack\WebHook\Reply\Reply;
use Crummy\Phlack\WebHook\SlashCommand;
use PhpSpec\ObjectBehavior;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

class ExpressionBotSpec extends ObjectBehavior
{
    function let($name, ExpressionLanguage $language, Iterocitor $iterocitor)
    {
        $this->beConstructedWith($name, $language, $iterocitor);
    }

    function it_extends_abstract_bot()
    {
        $this->shouldHaveType('Crummy\Phlack\Bot\ExpressionBot');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\Bot\AbstractBot');
    }

    function it_evaluates_expressions($language, $iterocitor, SlashCommand $command, Reply $reply)
    {
        $iterocitor->say('4')->willReturn($reply);
        $reply->offsetGet('text')->willReturn('4');

        $command->offsetGet('text')->willReturn('2 + 2');
        $language->evaluate('2 + 2', [])->willReturn('4');

        $this
            ->execute($command)['text']
                ->shouldReturn('4')
        ;
    }

    function it_returns_the_syntax_error_as_the_response_in_bad_commands($language, SlashCommand $command, $iterocitor, Reply $reply)
    {
        $command->offsetGet('text')->willReturn('foo + 2');

        $errorMessage   = 'Variable "foo" is not valid around position 1.';
        $error          = new SyntaxError('Variable "foo" is not valid', 1);

        $iterocitor->say($errorMessage)->willReturn($reply);
        $reply->offsetGet('text')->willReturn($errorMessage);

        $language->evaluate('foo + 2', [])->willThrow($error);

        $this
            ->execute($command)['text']
                ->shouldReturn($errorMessage);
        ;
    }
}
