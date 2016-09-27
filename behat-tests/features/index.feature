Feature: Simple Blog

  Scenario: Checking opening of homepage
    Given I am on the homepage
    Then I should see header with followed text "Simple Blog"
    And I should see first post header with followed text "The grid - A digital frontier"
    And I should see first post with followed content "Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum."

  Scenario: Checking posts creation with filling all fields
    Given I am on the homepage
    When I fill in the following:
      | post[title] | You're either a one or a zero. Alive or dead                                                                                          |
      | post[blog]  | Lorem ipsum dolor sit amet, consectetur adipiscing elittibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. |
      | post[tags]  | binary, one, zero, alive, dead, !trusting, movie, symblog                                                                             |
    And I attach the file "one_or_zero.jpg" to "post[image]"
    And I submit the form
    Then I should see first post header with followed text "You're either a one or a zero. Alive or dead"
    And I should see first post with followed content "Lorem ipsum dolor sit amet, consectetur adipiscing elittibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque."
