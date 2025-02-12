<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Clases;
use App\Entity\Usuarios;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiUsuariosController extends AbstractController
{
    #[Route('/api/usuarios', name: 'app_api_usuarios')]
    public function index(): Response
    {
        return $this->render('api_usuarios/index.html.twig', [
            'controller_name' => 'ApiUsuariosController',
        ]);
    }
    #[Route('/api/usuarios/addClase', methods: ['POST'], name: 'add_clase')]
public function addCalseUsuario(Request $request, EntityManagerInterface $em): JsonResponse
{
    $usuarioId = $request->get('usuario_id');
    $claseId = $request->get('clase_id');
    $data = json_decode($request->getContent(), associative: true);
    $usuario = $em->getRepository(Usuarios::class)->find($usuarioId);
    $clase = $em->getRepository(Clases::class)->find($claseId);

    $usuario->addClasesApuntada($clase);

    $em->persist($usuario);
    $em->persist($clase);
    $em->flush();
    return new JsonResponse(['success' => 'Clase agregada al usuario'], Response::HTTP_OK);

}
}
