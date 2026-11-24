<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoffeeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('coffee/index.html.twig');
    }

    #[Route('/menu', name: 'menu', methods: ['GET'])]
    public function menu(): Response
    {
        return $this->render('coffee/menu.html.twig');
    }

    #[Route('/about', name: 'about', methods: ['GET'])]
    public function about(): Response
    {
        return $this->render('coffee/about.html.twig');
    }
}