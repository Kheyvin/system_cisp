<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/{vueRouting}', name: 'vue_app', requirements: ['vueRouting' => '^(?!api|_wdt|_profiler).*$'], defaults: ['vueRouting' => null])]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }
}
