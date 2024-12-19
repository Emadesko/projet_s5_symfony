<?php

namespace App\Controller;

use App\Repository\DetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
   
    #[Route('/dette/api/client', name: 'app_dette_api')]
    public function getDettesByclient(DetteRepository $detteRepository, Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $type = $request->query->getString('type', "");
        $limit = 4;
        $dettes=[];
        $idClient = $request->query->getInt('id',0);
        $paginator = $detteRepository->paginateDettes($page,$limit,$idClient,$type);
        $count = $paginator->count();
        $maxPage = ceil($count / $limit);
        foreach ($paginator as $key => $value) {
            $paiements=[];
            foreach ($value->getPaiements() as $key => $p) {
                $paiements[]=[
                    'id' => $p->getId(),
                    'montant' => $p->getMontant(),
                    'createAt' => $p->getCreateAt()->format('Y-m-d'),
                ];
            }
            $articles=[];
            foreach ($value->getDetails() as $key => $d) {
                $articles[]=[
                    'id' => $d->getId(),
                    'prix' => $d->getPrix(),
                    'qte' => $d->getQte(),
                    'total' => $d->getTotal(),
                    'libelle' => $d->getArticle()->getLibelle(),
                ];
            }
            $dettes[]= [
                'id' => $value->getId(),
                'createAt' => $value->getCreateAt()->format('Y-m-d'),
                'montant' => $value->getMontant(),
                'montantVerser' => $value->getMontantVerser(),
                'montantRestant' => $value->getMontant() - $value->getMontantVerser(),
                'paiements' => $paiements,
                'articles' => $articles,
            ];
        }
        return $this->json([
            'datas' =>$dettes,
            'type' => $type,
            'page' => $page,
            'maxPage' => $maxPage,
        ]);
    }
}
