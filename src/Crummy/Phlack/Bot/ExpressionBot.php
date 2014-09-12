<?php

namespace Crummy\Phlack\Bot;

use Crummy\Phlack\Common\Matcher\CommandMatcher;
use Crummy\Phlack\Common\Responder\ResponderInterface;
use Crummy\Phlack\WebHook\CommandInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

class ExpressionBot extends AbstractBot
{
    /** @var \Symfony\Component\ExpressionLanguage\ExpressionLanguage */
    protected $language;

    /**
     * @param string             $commandName
     * @param ExpressionLanguage $language
     * @param ResponderInterface $responder
     */
    public function __construct($commandName = '/expr', ExpressionLanguage $language = null, ResponderInterface $responder = null)
    {
        $this->language = $language ?: new ExpressionLanguage();

        parent::__construct(new CommandMatcher($commandName), $responder);
    }

    /**
     * @param CommandInterface $command
     *
     * @return \Crummy\Phlack\WebHook\Reply\Reply
     */
    public function execute(CommandInterface $command)
    {
        try {
            $response = (string) $this->evaluate($command, $this->getValues($command));
        } catch (SyntaxError $badSyntax) {
            $response = $badSyntax->getMessage();
        }

        return $this->say($response);
    }

    /**
     * @param CommandInterface $command
     * @param array            $values
     *
     * @return string
     */
    protected function evaluate(CommandInterface $command, $values = [])
    {
        return $this->language->evaluate($command['text'], $values);
    }

    /**
     * @param CommandInterface $command
     *
     * @return array
     */
    protected function getValues(CommandInterface $command)
    {
        return [];
    }
}
