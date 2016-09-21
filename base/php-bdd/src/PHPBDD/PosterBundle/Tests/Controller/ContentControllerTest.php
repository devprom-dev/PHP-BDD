<?php

namespace PHPBDD\PosterBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContentControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(1, $crawler->filter('h1:contains("Simple Blog")')->count());
    }

    public function testPostsExists()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('article.blog')->count() > 0);
    }
}