<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Entity\User;
use App\Form\CommentType;
use App\Repository\PostRepository;
use App\Form\PostType;
use App\Form\SearchForm;
use Doctrine\ORM\EntityManagerInterface as ORMEntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum")
     */
    public function index(PostRepository $repo, Request $request)
    {
        $posts = $repo->findAll();
        $data = new SearchData();
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);

        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
            'posts' => $posts,
            'form' => $form->createView()

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
    public function show(Post $post, Request $request, ORMEntityManagerInterface $manager)
    {
        $comment = new Comment();

        $form = $this->createform(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser())
                ->setCreatedAt(new \DateTime())
                ->setPost($post);


            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('forum_show', ['id' => $post->getId()]);
        }

        return $this->render(
            'forum/show.html.twig',
            [
                'post' => $post,
                'commentForm' => $form->createView()
            ]
        );
    }


    /**
     * @Route("/forum/new", name="forum_create")
     * @Route("/forum/post/{id}/edit", name="forum_edit")
     */
    public function formPost(Post $post = null, Request $request, ORMEntityManagerInterface $manager)
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
