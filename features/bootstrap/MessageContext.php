<?php

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Crummy\Phlack\Message\Collection\AttachmentCollection;
use Crummy\Phlack\Message\Message;

class MessageContext extends BehatContext
{
    private $outputs = [];
    private $messages = [];
    private $attachments;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->attachments = new AttachmentCollection();
    }

    /**
     * @Given /^there are messages:$/
     */
    public function thereAreMessages(TableNode $table)
    {
        $hash = $table->getHash();
        foreach ($hash as $row) {
            $this->messages[] = new Message($row['text']);
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
                throw new Exception(sprintf('Expected: %s, Got:%s', $row['output'], $this->outputs[$key]));
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
     * Calls set{parameter} on each message.
     *
     * @param TableNode $table
     * @param $parameter
     */
    private function setMessageParameter(TableNode $table, $parameter)
    {
        $hash = $table->getHash();
        foreach ($hash as $key => $row) {
            $this->messages[$key][$parameter] = $row[$parameter];
        }
    }

    /**
     * @Transform /^table:text,channel$/
     * @Transform /^table:text,channel,username,icon_emoji$/
     */
    public function castMessageTable(TableNode $messagesTable)
    {
        $messages = [];
        foreach ($messagesTable->getHash() as $messageHash) {
            $args = [$messageHash['text']];
            foreach (['channel', 'username', 'icon_emoji'] as $parameter) {
                $args[] = isset($messageHash[$parameter]) ? $messageHash[$parameter] : null;
            }
            list($text, $channel, $username, $icon) = $args;
            $messages[] = new Message($text, $channel, $username, $icon);
        }

        return $messages;
    }

    /**
     * @Given /^these messages:$/
     */
    public function theseMessages(array $messages)
    {
        $this->messages = $messages;
    }

    /**
     * @Given /^I add an attachment with "([^"]*)" "([^"]*)" "([^"]*)" "([^"]*)"$/
     */
    public function iAddAnAttachmentWith($fallback, $title, $value, $isShort)
    {
        $isShort = (boolean) $isShort;
        $aBuilder = new \Crummy\Phlack\Builder\AttachmentBuilder();
        $attachment = $aBuilder->setFallback($fallback)->addField($title, $value, $isShort)->create();
        $this->attachments->add($attachment);
        /** @var Message $message */
        foreach ($this->messages as $message) {
            $message['attachments'] = $this->attachments;
        }
    }
}
