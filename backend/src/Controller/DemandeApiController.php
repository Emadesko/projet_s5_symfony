<?php

namespace App\Controller;

use App\Enum\Etat;
use App\Repository\DemandeRepository;
use App\Repository\DetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class DemandeApiController extends AbstractController
{

    #[Route('/demande/api', name: 'app_demande_api', methods:['GET'])]
    public function index(DemandeRepository $demandeRepository,Request $request,DetteRepository $detteRepository): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $demandes=[];
        $etat=$request->get('etat',Etat::EN_COURS->value);
        $paginator = $demandeRepository->paginateDemandes($page,$limit,$etat);
        $count = $paginator->count();
        $maxPage = ceil($count / $limit);
        foreach ($paginator as $key => $value) {
            $demandes[]= [
                'id' => $value->getId(),
                'createAt' => $value->getCreateAt()->format('Y-m-d'),
                'etat' => $value->getEtat()->name,
                'montant' => $value->getMontant(),
                'client' => [
                    'id' => $value->getClient()->getId(),
                    'surname' => $value->getClient()->getSurname(),
                    'telephone' => $value->getClient()->getTelephone(),
                    'adresse' => $value->getClient()->getAdresse(),
                    'compte' => [
                            'id' => $value->getClient()->getCompte()->getId(),
                            'role' => $value->getClient()->getCompte()->getRole()->name,
                            'isActive' => $value->getClient()->getCompte()->isActive(),
                            'email' => $value->getClient()->getCompte()->getEmail(),
                            'password' => $value->getClient()->getCompte()->getPassword(),
                            'prenom' => $value->getClient()->getCompte()->getPrenom(),
                            'nom' => $value->getClient()->getCompte()->getNom(),
                            'login' => $value->getClient()->getCompte()->getLogin()
                        ],
                    ],
                'montant' => $detteRepository->getTotalMontant($value->getClient()->getId()),
                'montantVerser' => $detteRepository->getTotalMontantVerser($value->getClient()->getId())
                
            ];
        }
        return $this->json([
            'datas' =>$demandes,
            'etat' => $etat,
            'page' => $page,
            'maxPage' => $maxPage,
        ]);
    }
 
    #[Route('/demande/data', name: 'app_demande' ,methods:['GET'])]
    public function ccc(DemandeRepository $demandeRepository): JsonResponse
    {
        $sik=$demandeRepository->findAll();
        $datas = [];

        foreach ($sik as $demande) {  
            $datas[] = [  
                'id' => $demande->getId(),  
                'libelle' => $demande->getMontant(), // Assurez-vous d'avoir une méthode getLibelle()  
            ];  
        }
        return $this->json($datas);
    }
}
