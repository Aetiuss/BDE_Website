<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     * @return Response
     */

    public function index(PostRepository $repository)
    {
        $this->repository;
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
}
