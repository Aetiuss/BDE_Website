<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Entity\Report;
use App\Form\CommentType;
use App\Repository\PostRepository;
use App\Form\PostType;
use App\Form\ReportType;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface as ORMEntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ForumController extends AbstractController
{
    /**
     * @var PostRepository
     */
    private $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @Route("/forum", name="forum")
     * @IsGranted("ROLE_USER") 
     */
    public function index(PostRepository $repo, Request $request, PaginatorInterface $paginator)
    {
        $posts = $repo->findBy([], ['category' => 'DESC']);
        $search = new SearchData();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
            'posts' => $posts,
            'properties' => $properties,
            'form' => $form->createView(),

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
    /**
     * @Route("/forum/post/{id}/report", name="forum_report")
     */
    public function report(Post $post, Request $request, ORMEntityManagerInterface $manager)
    {
        $report = new Report();

        $form = $this->createForm(ReportType::class, $report);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $report->setUser($this->getUser())
                ->setPost($post);

            $manager->persist($report);
            $manager->flush();

            return $this->redirectToRoute('forum_show', ['id' => $post->getId()]);
        }


        return $this->render('forum/report.html.twig', ['reportForm' => $form->createView()]);
    }
}
