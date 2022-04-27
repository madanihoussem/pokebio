<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProduitsRepository $produitsRepository): Response
    {
        $produits = $produitsRepository->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Accueil - Poké Bio',
            'produits' => $produits,
        ]);
    } 
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(): Response
    {
        
        return $this->render('home/dashboard.html.twig', [
            'controller_name' => 'Dashboard - Poké Bio',
        ]);
    }
    #[Route('/articles', name: 'blog_liste', methods: ['GET'])]
    public function blog(BlogRepository $blogRepository): Response
    {
        return $this->render('home/blog.html.twig', [
            'blogs' => $blogRepository->findAll(),
        ]);
    }
}
