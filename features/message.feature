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

  Scenario: Messages with icons
    Given there are messages:
     | text                  |
     | This is the default.  |
     | This is a Package.    |
     | This is a Cookie.     |
     | This is an Hourglass. |
     | This is a Copyright.  |
   When I set their icon emojis:
     | icon_emoji |
     |            |
     | package    |
     | :cookie:   |
     | :hourglass |
     | copyright: |
   And I echo the message
   Then I get the output:
     | output                                                      |
     | {"text":"This is the default."}                             |
     | {"text":"This is a Package.","icon_emoji":":package:"}      |
     | {"text":"This is a Cookie.","icon_emoji":":cookie:"}        |
     | {"text":"This is an Hourglass.","icon_emoji":":hourglass:"} |
     | {"text":"This is a Copyright.","icon_emoji":":copyright:"}  |

  Scenario: Messages with usernames
    Given there are messages:
      | text                  |
      | This is from default. |
      | This is from Adam.    |
      | This is from Ben.     |
      | This is from Carl.    |
      | This is from Daryl.   |
    When I set their usernames:
      | username      |
      |               |
      | heydudeimadam |
      | bdotfranklin  |
      | cmalone       |
      | otherdaryl    |
    And I echo the message
    Then I get the output:
      | output                                                   |
      | {"text":"This is from default."}                         |
      | {"text":"This is from Adam.","username":"heydudeimadam"} |
      | {"text":"This is from Ben.","username":"bdotfranklin"}   |
      | {"text":"This is from Carl.","username":"cmalone"}       |
      | {"text":"This is from Daryl.","username":"otherdaryl"}   |

  Scenario: The kitchen sink of Messages
    Given these messages:
      | text | channel | username | icon_emoji  |
      | 000  |         |          |             |
      | 001  |         |          | package     |
      | 010  |         | albert   |             |
      | 011  |         | bob      | clock       |
      | 100  | nbc     |          |             |
      | 101  | cbs     |          | hourglass   |
      | 110  | abc     | carl     |             |
      | 111  | fox     | doge     | copyright   |
    When I echo the message
    Then I get the output:
      | output                                                                       |
      | {"text":"000"}                                                               |
      | {"text":"001","icon_emoji":":package:"}                                      |
      | {"text":"010","username":"albert"}                                           |
      | {"text":"011","username":"bob","icon_emoji":":clock:"}                       |
      | {"text":"100","channel":"#nbc"}                                              |
      | {"text":"101","channel":"#cbs","icon_emoji":":hourglass:"}                   |
      | {"text":"110","channel":"#abc","username":"carl"}                            |
      | {"text":"111","channel":"#fox","username":"doge","icon_emoji":":copyright:"} |

  Scenario: Message Attachments
    Given these messages:
      | message | channel |
      | Default |         |
    When I add an attachment with "fallback" "title" "value" "true"
      And I echo the message
    Then I get the output:
      | output                                                                                                               |
      | {"text":"Default","attachments":[{"fallback":"fallback","fields":[{"title":"title","value":"value","short":true}]}]} |
