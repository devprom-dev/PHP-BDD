<?php

use Behat\MinkExtension\Context\MinkContext;
use PHPUnit_Framework_Assert as Assert;

class FeatureContext extends MinkContext
{
    /**
     * @BeforeScenario
     */
    public function clearData() {
        //Так как мы не используем возможности Symfony, то чистить базу данных приходится таким способом:
        shell_exec('docker exec `docker ps -q -f name=.base.` php app/console doctrine:fixtures:load --fixtures=src/PHPBDD/PosterBundle/Tests/DataFixtures/ORM');
    }

    /**
     * @Given /^I should see header with followed text "([^"]*)"$/
     */
    public function shouldSeeHeader($text)
    {
        $xpath = "//h1[1]";
        $el = $this->getSession()->getPage()->find('xpath', $xpath);
        Assert::assertEquals($el->getText(), $text);
    }

    /**
     * @Given /^I should see first post with followed content "([^"]*)"$/
     */
    public function shouldSeeBlog($content)
    {
        $xpath = "//div[@class='snippet']/p";
        $el = $this->getSession()->getPage()->find('xpath', $xpath);
        Assert::assertEquals($el->getText(), $content);
    }

    /**
     * @Given /^I should see first post header with followed text "([^"]*)"$/
     */
    public function shouldSeePostHeader($text)
    {
        $xpath = "//article[1]/header/h2/a";
        $el = $this->getSession()->getPage()->find('xpath', $xpath);
        Assert::assertEquals($el->getText(), $text);
    }

    /**
     * @Given /^I submit the form$/
     */
    public function iSubmitTheForm()
    {
        $xpath = "//form//input[@type='submit']";
        $el = $this->getSession()->getPage()->find('xpath', $xpath);
        $el->click();
    }
}
