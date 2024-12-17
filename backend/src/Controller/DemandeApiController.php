<?php

namespace App\Controller;

use App\Repository\DemandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class DemandeApiController extends AbstractController
{
    #[Route('/demande/api', name: 'app_demande_api')]
    public function index(DemandeRepository $demandeRepository): JsonResponse
    {
        return $this->json([
            'datas' => $demandeRepository->findAll(),
        ]);
    }
}
