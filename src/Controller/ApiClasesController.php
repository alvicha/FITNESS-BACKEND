<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiClasesController extends AbstractController
{
    #[Route('/api/clases', name: 'app_api_clases')]
    public function index(): Response
    {
        return $this->render('api_clases/index.html.twig', [
            'controller_name' => 'ApiClasesController',
        ]);
    }
}
