<?php

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Crummy\Phlack\Builder\AttachmentBuilder;

class MessageAttachmentContext extends BehatContext
{
    use ParameterTrait;

    /** @var \Crummy\Phlack\Builder\AttachmentBuilder */
    private $builder;

    /**
     * @Given /^I have an AttachmentBuilder$/
     */
    public function iHaveAnAttachmentbuilder()
    {
        $this->builder = new AttachmentBuilder();
    }

    /**
     * @When /^I set fallback to "([^"]*)"$/
     */
    public function iSetFallbackTo($fallback)
    {
        $this->builder->setFallback($fallback);
    }

    /**
     * @Given /^I add the fields:$/
     */
    public function iAddTheFields(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $this->builder->addField($row['title'], $row['value'], (boolean) $row['short']);
        }
    }

    /**
     * @Given /^I build the attachment$/
     */
    public function iBuildTheAttachment()
    {
        $attachment = $this->builder->create();
        OutputContext::pushOutput((string) $attachment);
    }
}
