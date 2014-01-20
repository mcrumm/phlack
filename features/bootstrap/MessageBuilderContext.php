<?php

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Crummy\Phlack\Builder\MessageBuilder;

class MessageBuilderContext extends BehatContext
{
    use ParameterTrait;

    /**
     * @When /^I build the messages:$/
     */
    public function iBuildTheMessages(array $messages)
    {
        foreach ($messages as $message) {
            OutputContext::pushOutput((string)$message);
        }
    }

    /**
     * @Transform /^table:message$/
     * @Transform /^table:message,channel$/
     * @Transform /^table:message,channel,username$/
     * @Transform /^table:message,channel,username,icon_emoji$/
     */
    public function castMessageTable(TableNode $messagesTable)
    {
        $builder  = new MessageBuilder();
        $messages = [];
        foreach ($messagesTable->getHash() as $messageHash) {
            $builder->setText($messageHash['message']);
            foreach (['channel', 'username', 'icon_emoji'] as $parameter) {
                $method = 'set' . $this->toMethodName($parameter);
                if (isset($messageHash[$parameter])) {
                    $builder->{$method}($messageHash[$parameter]);
                }
            }
            $messages[] = $builder->create();
        }

        return $messages;
    }
}
