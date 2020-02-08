<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Post;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Role;
use App\Entity\User;
use DateTime;
use Faker;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        $roleUser = (new Role())->setTitle("ROLE_USER");

        $roleAdmin = (new Role())->setTitle("ROLE_ADMIN");

        $manager->persist($roleUser);
        $manager->persist($roleAdmin);


        //Faire 3 catégories
        for ($h = 1; $h <= 3; $h++) {
            $category = new Category();

            $category->setTitle($faker->word())
                ->setDescription($faker->paragraph());

            $manager->persist($category);

            //Faire 5 utilisateurs
            for ($i = 1; $i <= 5; $i++) {
                $user = new User();

                $user->setEmail($faker->email())
                    ->setUsername($faker->name())
                    ->setPassword($faker->sentence())
                    ->setRoles($roleUser);

                $manager->persist($user);


                //Faire 1 à 3 posts
                for ($j = 1; $j <= 3; $j++) {
                    $post = new Post();

                    $content = '<p>' . join($faker->paragraphs(5)) . '</p>';

                    $post->setTitle($faker->sentence())
                        ->setContent($content)
                        ->setPicture($faker->imageUrl())
                        ->setCreatedAt($faker->dateTimeBetween("-6 months"))
                        ->setCategory($category)
                        ->setUser($user);

                    $user->addPost($post);

                    $manager->persist($post);
                    $manager->persist($user);

                    //Faire 2 à 5 commentaires avec un utilisateur associé a chacuns
                    for ($k = 1; $k <= mt_rand(2, 5); $k++) {
                        $comment = new Comment();
                        $user = new User();

                        $user->setEmail($faker->email())
                            ->setUsername($faker->name())
                            ->setPassword($faker->sentence())
                            ->setRoles($roleUser);


                        $content = '<p>' . join($faker->paragraphs(2)) . '</p>';

                        $days = (new \DateTime())->diff($post->getCreatedAt())->days;

                        $comment->setAuthor($user)
                            ->setContent($content)
                            ->setCreatedAt($faker->dateTimeBetween('-' . $days . ' days '))
                            ->setPost($post);

                        $user->addComment($comment);

                        $manager->persist($comment);
                        $manager->persist($user);
                    }
                }
            }
        }
        $manager->flush();
    }
}
