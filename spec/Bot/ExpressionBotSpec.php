<?php

namespace spec\Crummy\Phlack\Bot;

use Crummy\Phlack\WebHook\Command;
use PhpSpec\ObjectBehavior;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

class ExpressionBotSpec extends ObjectBehavior
{
    function let($name, ExpressionLanguage $language)
    {
        $this->beConstructedWith($name, $language);
    }

    function it_extends_abstract_bot()
    {
        $this->shouldHaveType('Crummy\Phlack\Bot\ExpressionBot');
        $this->shouldBeAnInstanceOf('\Crummy\Phlack\Bot\AbstractBot');
    }

    function it_evaluates_expressions($language)
    {
        $command = new Command([
            'text' => '2 + 2',
        ]);

        $language
            ->evaluate('2 + 2', [])
            ->willReturn('4')
        ;

        $this
            ->execute($command)['text']
            ->shouldReturn('4')
        ;
    }

    function it_returns_the_syntax_error_as_the_response_in_bad_commands($language)
    {
        $command = new Command([
            'text' => 'foo + 2',
        ]);

        $errorMessage = 'Variable "foo" is not valid around position 1.';
        $error = new SyntaxError('Variable "foo" is not valid', 1);

        $language
            ->evaluate($command['text'], [])
            ->willThrow($error)
        ;

        $this
            ->execute($command)['text']
            ->shouldBe($errorMessage)
        ;
    }
}
