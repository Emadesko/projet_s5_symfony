<?php

namespace App\Controller;

use App\Repository\CompteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CompteApiController extends AbstractController
{
    #[Route('/compte/api', name: 'app_compte_api')]
    public function index(CompteRepository $compteRepository): JsonResponse
    {
        return $this->json([
            'datas' => $compteRepository->findAll(),
        ]);
    }
}
