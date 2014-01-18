Feature: Phlack Message
  As a developer
  In order to send messages to Slack
  I need a Message object that outputs as JSON

  Scenario: Simple Messages
    Given there are messages:
      | text    |
      | Hi      |
      | Hello   |
      | Howdy   |
    When I echo the message
    Then I get the output:
      | output           |
      | {"text":"Hi"}    |
      | {"text":"Hello"} |
      | {"text":"Howdy"} |

  Scenario: Channel-specific Messages
    Given there are messages:
      | text    |
      | Default |
      | Dev     |
      | Ops     |
      | Banana  |
    When I set their channels:
      | channel  |
      |          |
      | dev      |
      | #ops     |
      | ##banana |
    And I echo the message
    Then I get the output:
      | output                                 |
      | {"text":"Default"}                     |
      | {"text":"Dev","channel":"#dev"}        |
      | {"text":"Ops","channel":"#ops"}        |
      | {"text":"Banana","channel":"##banana"} |

