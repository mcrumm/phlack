Feature: Message Builder
  As a developer
  In order to create verbose messages
  I need a MessageBuilder

  Scenario: Building Simple Messages
    When I build a message:
      | text              |
      | A simple message. |
    Then I should get the payload:
      | payload                      |
      | {"text":"A simple message."} |
