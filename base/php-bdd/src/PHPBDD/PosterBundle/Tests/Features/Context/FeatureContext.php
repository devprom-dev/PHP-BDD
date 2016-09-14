<?php

namespace PHPBDD\PosterBundle\Tests\Features\Context;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Context\Context;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;
use PHPUnit_Framework_Assert as Assert;

use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader as DataFixturesLoader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

class FeatureContext extends MinkContext implements Context, KernelAwareContext
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * {@inheritdoc}
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this->kernel->getContainer();
    }

    /**
     * @AfterScenario
     */
    public function clearData() {
        $paths = array();
        foreach ($this->kernel->getBundles() as $bundle) {
            $paths[] = $bundle->getPath().'/DataFixtures/ORM';
        }
        $loader = new DataFixturesLoader($this->getContainer());
        foreach ($paths as $path) {
            if (is_dir($path)) {
                $loader->loadFromDirectory($path);
            }
        }
        $em = $this->getContainer()->get('doctrine')->getManager();
        //print_r($em);
        $fixtures = $loader->getFixtures();
        $purger = new ORMPurger($em);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_DELETE);
        $executor = new ORMExecutor($em, $purger);
        $append = false;
        $executor->execute($fixtures, $append);
    }

    /**
     * @Given /^I wait for (\d+) seconds$/
     */
    public function waitForSeconds($seconds)
    {
        $this->getSession()->wait($seconds * 1000);
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
}
