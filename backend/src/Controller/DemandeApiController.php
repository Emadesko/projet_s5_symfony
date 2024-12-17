<?php

namespace App\Controller;

use App\Enum\Etat;
use App\Repository\DemandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class DemandeApiController extends AbstractController
{
    #[Route('/demande/api', name: 'app_demande_api')]
    public function index(DemandeRepository $demandeRepository,Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $demandes=[];
        $etat=$request->get('etat',Etat::EN_COURS->value);
        $demandes = $demandeRepository->paginateDemandes($page,$limit,$etat);
        $count = $demandes->count();
        $maxPage = ceil($count / $limit);
        return $this->json([
            'datas' => $demandes,
            'etat' => $etat,
            'page' => $page,
            'maxPage' => $maxPage,
        ]);
    }
}
