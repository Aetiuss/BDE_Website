<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Repository\PostRepository;

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
     * @Route("/forum/post/{id}", name="blog_show")
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
     * @Route("/forum/new", name="blog_create")
     * @Route("/forum/{id}/edit", name="blog_create")
     */
    public function create()
    {
        return $this->render('blog/create.html.twig');
    }
}
