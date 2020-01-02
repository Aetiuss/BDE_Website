<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Form\PostType;

use Doctrine\ORM\EntityManagerInterface as ORMEntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum")
     */
    public function index(PostRepository $repo)
    {
        $posts = $repo->findAll();

        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
            "posts" => $posts
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('forum/home.html.twig');
    }

    /**
     * @Route("/forum/post/{id}", name="forum_show")
     */
    public function show(PostRepository $repo, $id)
    {
        $post = $repo->find($id);

        return $this->render(
            'forum/show.html.twig',
            [
                'post' => $post
            ]
        );
    }


    /**
     * @Route("/forum/new", name="forum_create")
     * @Route("/forum/post/{id}/edit", name="forum_edit")
     */
    public function form(Post $post = null, Request $request, ORMEntityManagerInterface $manager)
    {
        if (!$post) {
            $post = new Post();
        }

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$post->getId()) {
                $post->SetCreatedAt(new \Datetime());
            }

            $manager->persist($post);
            $manager->flush();

            return $this->redirectToRoute('forum_show', ['id' => $post->getId()]);
        }

        return $this->render('forum/create.html.twig', [
            'formPost' => $form->createView(),
            'editMode' => $post->getId() !== null
        ]);
    }
}
