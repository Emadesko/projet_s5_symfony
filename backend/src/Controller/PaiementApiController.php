<?php

namespace App\Controller;

use App\Repository\PaiementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class PaiementApiController extends AbstractController
{
    #[Route('/paiement/api', name: 'app_paiement_api')]
    public function index(PaiementRepository $paiementRepository): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PaiementApiController.php',
            'datas' => $paiementRepository->findAll(),
        ]);
    }
}
