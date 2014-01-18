Feature: Phlack Message
  As a developer
  In order to send messages to Slack
  I need a Message object that outputs as JSON

  Scenario: Simple Message
    Given a message containing "Howdy!"
    When I call "__toString" on the message
    Then I should get:
    """
    {"text":"Howdy!"}
    """
