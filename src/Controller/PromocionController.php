<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/promocion', name: 'api_promocion_')]
class PromocionController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('promocion/index.html.twig', [
            'controller_name' => 'PromocionController',
        ]);
    }
}
