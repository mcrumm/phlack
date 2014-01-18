<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    private $output;
    private $message;

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        doSomethingWith($argument);
//    }
//


    /**
     * @Given /^I want to send the message "([^"]*)"$/
     */
    public function iWantToSendTheMessage($text)
    {
        $this->message = new \Crummy\Phlack\Message($text);
    }

    /**
     * @When /^I echo the message$/
     */
    public function iEchoTheMessage()
    {
        $this->output = (string)$this->message;
    }

    /**
     * @Then /^I should get: \'([^\']*)\'$/
     */
    public function iShouldGet($text)
    {
        if ($text !== $this->output) {
            throw new Exception(sprintf("Actual output:\n%s", $this->output));
        }
    }

    /**
     * @Then /^I should get: {"text": "Howdy!"}$/
     */
    public function iShouldGetTextHowdy()
    {
        throw new PendingException();
    }
}
