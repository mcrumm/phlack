<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

class MessageContext extends BehatContext
{
    private $outputs  = array();
    private $messages = array();

    /**
     * @Given /^there are messages:$/
     */
    public function thereAreMessages(TableNode $table)
    {
        $hash = $table->getHash();
        foreach ($hash as $row) {
            $this->messages[] = new \Crummy\Phlack\Message($row['text']);
        }
    }

    /**
     * @When /^I echo the message$/
     */
    public function iEchoTheMessage()
    {
        foreach ($this->messages as $message) {
            $this->outputs[] = (string) $message;
        }
    }

    /**
     * @Then /^I get the output:$/
     */
    public function iGetTheOutput(TableNode $table)
    {
        $hash = $table->getHash();
        foreach ($hash as $key => $row) {
            if ($row['output'] !== $this->outputs[$key]) {
                throw new Exception(sprintf("Expected: %s, Got:%s", $row['output'], $this->outputs[$key]));
            }
        }
    }

    /**
     * @When /^I set their channels:$/
     */
    public function iSetTheirChannels(TableNode $table)
    {
        $this->setMessageParameter($table, 'channel');
    }

    /**
     * @When /^I set their icon emojis:$/
     */
    public function iSetTheirIconEmojis(TableNode $table)
    {
        $this->setMessageParameter($table, 'icon_emoji');
    }

    /**
     * @When /^I set their usernames:$/
     */
    public function iSetTheirUsernames(TableNode $table)
    {
        $this->setMessageParameter($table, 'username');
    }

    /**
     * Calls set{parameter} on each message
     * @param TableNode $table
     * @param $parameter
     */
    private function setMessageParameter(TableNode $table, $parameter)
    {
        $method = 'set' . $this->toMethodName($parameter);
        $hash = $table->getHash();
        foreach ($hash as $key => $row) {
            $this->messages[$key]->{$method}($row[$parameter]);
        }
    }

    /**
     * @Transform /^table:text,channel,username,icon_emoji$/
     */
    public function castMessageTable(TableNode $messagesTable)
    {
        $messages = array();
        foreach ($messagesTable->getHash() as $messageHash) {
            $message    = new \Crummy\Phlack\Message($messageHash['text']);
            foreach(array('channel','username','icon_emoji',) as $parameter) {
                $method = 'set' . $this->toMethodName($parameter);
                if (isset($messageHash[$parameter])) {
                    $message->{$method}($messageHash[$parameter]);
                }
            }
            $messages[] = $message;
        }

        return $messages;
    }

    /**
     * @param string $parameter
     * @return string
     */
    private function toMethodName($parameter)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $parameter)));
    }

    /**
     * @Given /^these messages:$/
     */
    public function theseMessages(array $messages)
    {
        $this->messages = $messages;
    }
}
