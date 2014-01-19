Feature: Message Builder
  As a developer
  In order to create verbose messages
  I need a MessageBuilder

  Scenario: Building Simple Messages
    When I build the messages:
      | message           |
      | A simple message. |
    Then I should get the payload:
      | payload                      |
      | {"text":"A simple message."} |

  Scenario: Building Simple Messages with Channels
    When I build the messages:
      | message            | channel |
      | A default message. |         |
      | Message for bars.  | bar     |
      | Message for foos.  | foo     |
    Then I should get the payload:
      | payload                                       |
      | {"text":"A default message."}                 |
      | {"text":"Message for bars.","channel":"#bar"} |
      | {"text":"Message for foos.","channel":"#foo"} |