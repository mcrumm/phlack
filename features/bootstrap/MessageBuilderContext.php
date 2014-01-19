<?php

use Behat\Behat\Context\BehatContext;

use Behat\Gherkin\Node\TableNode;

class MessageBuilderContext extends BehatContext
{
    private $messages = array();

    /**
     * @When /^I build a message:$/
     */
    public function iBuildAMessage(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $builder          = new \Crummy\Phlack\MessageBuilder();
            $this->messages[] = $builder->setText($row['text'])->create();
        }
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
