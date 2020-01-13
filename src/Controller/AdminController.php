<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin_2", name="admin")
     */
    public function index(UserRepository $uRepo, CategoryRepository $cRepo)
    {
        $users = $uRepo->findAll();
        $categories = $cRepo->findAll();
        $users = $uRepo->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'categories' => $categories,
        ]);
    }
}
