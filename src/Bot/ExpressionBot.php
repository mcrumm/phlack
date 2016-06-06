<?php

namespace Crummy\Phlack\Bot;

use Crummy\Phlack\Message\Message;
use Crummy\Phlack\WebHook\Command;
use Crummy\Phlack\WebHook\Matcher\CommandMatcher;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

class ExpressionBot extends AbstractBot
{
    /** @var \Symfony\Component\ExpressionLanguage\ExpressionLanguage */
    protected $language;

    /**
     * @param string             $commandName
     * @param ExpressionLanguage $language
     */
    public function __construct($commandName = '/expr', ExpressionLanguage $language = null)
    {
        $this->language = $language ?: new ExpressionLanguage();

        parent::__construct(new CommandMatcher($commandName));
    }

    /**
     * @param Command $command
     *
     * @return Message
     */
    public function execute(Command $command)
    {
        try {
            $response = (string) $this->evaluate($command, $this->getValues($command));
        } catch (SyntaxError $badSyntax) {
            $response = $badSyntax->getMessage();
        }

        return $this->say($response);
    }

    /**
     * @param Command $command
     * @param array            $values
     *
     * @return string
     */
    protected function evaluate(Command $command, $values = [])
    {
        return $this->language->evaluate($command['text'], $values);
    }

    /**
     * @param Command $command
     *
     * @return array
     */
    protected function getValues(Command $command)
    {
        return [];
    }
}
