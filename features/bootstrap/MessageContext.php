<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

class MessageContext extends BehatContext
{
    private $output;
    private $message;

    /**
     * @Given /^a message containing "([^"]*)"$/
     */
    public function aMessageContaining($text)
    {
        $this->message = new \Crummy\Phlack\Message($text);
    }

    /**
     * @When /^I call "([^"]*)" on the message$/
     */
    public function iCallOnTheMessage($method)
    {
        $this->output = call_user_func(array($this->message, $method));
    }

    /**
     * @Then /^I should get:$/
     */
    public function iShouldGet(PyStringNode $string)
    {
        if ((string)$string !== $this->output) {
            throw new Exception(sprintf("Actual output:\n%s", $this->output));
        }
    }
}
