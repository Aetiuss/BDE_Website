<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{


    public function index(PostRepository $repository, Request $request)
    {
        /* $data = new SearchData();
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);

        //dd($data);

        $posts = $repository->findSearch();
        return $this->render('forum/index.html.twig', [
            'posts' => $posts,
            'form' => $form->createView()
        ]); */ }
}
