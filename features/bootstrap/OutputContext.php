<?php

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;

class OutputContext extends BehatContext
{
    static protected $outputs = [];

    public static function pushOutput($output)
    {
        self::$outputs[] = $output;
    }

    /**
     * @Then /^I should get the payload:$/
     */
    public function iShouldGetThePayload(TableNode $table)
    {
        foreach ($table->getHash() as $key => $row) {
            $payload = (string)self::$outputs[$key];
            if ($row['payload'] !== $payload) {
                self::$outputs = [];    // Reset the outputs
                throw new Exception(sprintf("Expected: %s,\n but got: %s", $row['payload'], $payload));
            }
        }

        self::$outputs = [];    // Reset the outputs
    }
}
