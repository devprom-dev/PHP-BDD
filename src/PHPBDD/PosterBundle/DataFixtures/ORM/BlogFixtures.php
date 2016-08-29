<?php

namespace PHPBDD\PosterBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPBDD\PosterBundle\Entity\Posts;

class BlogFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $post1 = new Posts();
        $post1->setTitle('The grid - A digital frontier');
        $post1->setBlog('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum.');
        $post1->setImage('the_grid.jpg');
        $post1->setTags('grid, daftpunk, movie, symblog');
        $manager->persist($post1);

        $post2 = new Posts();
        $post2->setTitle('The pool on the roof must have a leak');
        $post2->setBlog('Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Na. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis. Lorem ipsumvehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Lorem commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra.');
        $post2->setImage('pool_leak.jpg');
        $post2->setTags('pool, leaky, hacked, movie, hacking, symblog');
        $manager->persist($post2);

        $manager->flush();
    }
}

