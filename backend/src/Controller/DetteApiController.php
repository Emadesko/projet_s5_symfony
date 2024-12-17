<?php

namespace App\Controller;

use App\Repository\DetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class DetteApiController extends AbstractController
{
    #[Route('/dette/api', name: 'app_dette_api')]
    public function index(DetteRepository $detteRepository): JsonResponse
    {
        return $this->json([
            'datas' => $detteRepository->findAll(),
        ]);
    }
}
