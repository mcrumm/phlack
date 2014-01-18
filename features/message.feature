Feature: Phlack Message
  As a developer
  In order to send messages to Slack
  I need a Message object that outputs as JSON

  Scenario: Create a simple message
    Given I want to send the message "Howdy!"
    When I echo the message
    Then I should get: {"text": "Howdy!"}