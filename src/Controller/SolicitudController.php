<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/solicitud', name: 'api_solicitud_')]
class SolicitudController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('solicitud/index.html.twig', [
            'controller_name' => 'SolicitudController',
        ]);
    }
}
