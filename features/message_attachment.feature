Feature: Attachment Builder
  As a developer
  In order to create attachments
  I need an AttachmentBuilder

  Scenario: Basic Attachment
    Given I have an AttachmentBuilder
    When I set fallback to "the fallback"
    And I add the fields:
      | title          | value          | short |
      | the title      | the value      | 1     |
      | the long title | the long value | 0     |
    And I build the attachment
    Then I should get the payload:
      | payload |
      | {"fallback":"the fallback","fields":[{"title":"the title","value":"the value","short":true},{"title":"the long title","value":"the long value","short":false}]} |
