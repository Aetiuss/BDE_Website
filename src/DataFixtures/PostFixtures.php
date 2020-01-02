<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Post;
use DateTime;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $post = new Post();
            $post->setTitle("Titre du post n°$i")
                ->setContent("<p>Contenu du post n°$i<p>")
                ->setPicture("http://placehold.it/350x150")
                ->setCreatedAt(new \DateTime());

            $manager->persist($post);
        }
        $manager->flush();
    }
}
