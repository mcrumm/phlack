<?php

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Crummy\Phlack\Message\Message;

class MessageBuilderContext extends BehatContext
{
    use ParameterTrait;

    private $messages = [];

    /**
     * @When /^I build the messages:$/
     */
    public function iBuildTheMessages(array $messages)
    {
        $this->messages = $messages;
    }

    /**
     * @Transform /^table:message$/
     * @Transform /^table:message,channel$/
     * @Transform /^table:message,channel,username$/
     * @Transform /^table:message,channel,username,icon_emoji$/
     */
    public function castMessageTable(TableNode $messagesTable)
    {
        $builder  = new \Crummy\Phlack\MessageBuilder();
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

    /**
     * @Then /^I should get the payload:$/
     */
    public function iShouldGetThePayload(TableNode $table)
    {
        foreach ($table->getHash() as $key => $row) {
            $payload = (string)$this->messages[$key];
            if ($row['payload'] !== $payload) {
                throw new Exception(sprintf("Expected: %s,\n but got: %s", $row['payload'], $payload));
            }
        }
    }
}
