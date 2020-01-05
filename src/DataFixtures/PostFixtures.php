<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Post;
use App\Entity\Category;
use App\Entity\Comment;

use DateTime;
use Faker;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 3; $i++) {
            $category = new Category();
            $category->setTitle($faker->word())
                ->setDescription($faker->paragraph());

            $manager->persist($category);

            for ($j = 1; $j <= mt_rand(4, 6); $j++) {
                $post = new Post();

                $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

                $post->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setPicture($faker->imageUrl())
                    ->setCreatedAt($faker->dateTimeBetween("-6 months"))
                    ->setCategory($category);

                $manager->persist($post);


                for ($k = 1; $k <= mt_rand(4, 10); $k++) {
                    $comment = new Comment();

                    $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

                    $days = (new \DateTime())->diff($post->getCreatedAt())->days;

                    $comment->setAuthor($faker->name)
                        ->setContent($content)
                        ->setCreatedAt($faker->dateTimeBetween('-' . $days . ' days '))
                        ->setArticle($post);

                    $manager->persist($comment);
                }
            }

            for ($i = 1; $i <= 10; $i++) {
                $post = new Post();
                $post->setTitle($faker->sentence())
                    ->setContent("<p>Contenu du post n°$i<p>")
                    ->setPicture("http://placehold.it/350x150")
                    ->setCreatedAt(new \DateTime());

                $manager->persist($post);
            }
            $manager->flush();
        }
    }
}
