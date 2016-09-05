<?php

namespace PHPBDD\PosterBundle\Tests\Entity;

use PHPBDD\PosterBundle\Entity\Posts;

class PostsTest extends \PHPUnit_Framework_TestCase
{
    public function testSetTitle()
    {
        $post = new Posts();
        $post->setTitle('You\'re either a one or a zero. Alive or dead');
        $this->assertEquals('You\'re either a one or a zero. Alive or dead', $post->getTitle());
    }

    public function testSetAuthor()
    {
        $post = new Posts();
        $post->setAuthor('admin');
        $this->assertEquals('admin', $post->getAuthor());
    }

    public function testSetBlog()
    {
        $post = new Posts();
        $post->setBlog('Lorem ipsum dolor sit amet, consectetur adipiscing elittibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque.');
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elittibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque.', $post->getBlog());
    }

    public function testSetImage()
    {
        $post = new Posts();
        $post->setImage('one_or_zero.jpg');
        $this->assertEquals('one_or_zero.jpg', $post->getImage());
    }

    public function testSetTags()
    {
        $post = new Posts();
        $post->setTags('binary, one, zero, alive, dead, !trusting, movie, symblog');
        $this->assertEquals('binary, one, zero, alive, dead, !trusting, movie, symblog', $post->getTags());
    }

    public function testSetCreated()
    {
        $post = new Posts();
        $post->setCreated(new \DateTime());
        $this->assertEquals(new \DateTime(), $post->getCreated());
    }
}
