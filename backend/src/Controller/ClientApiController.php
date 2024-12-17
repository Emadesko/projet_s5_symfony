<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Compte;
use App\Repository\ClientRepository;
use App\Repository\DetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ClientApiController extends AbstractController
{
    #[Route('/client/api', name: 'app_client_api')]
    public function index(ClientRepository $clientRepository,Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $clients=[];
        $telephone=$request->get('telephone',"");
        $clients = $clientRepository->paginateClients($page,$limit,$telephone);
        $count = $clients->count();
        $maxPage = ceil($count / $limit);
        return $this->json([
            'datas' => $clients,
            'telephone' => $telephone,
            'page' => $page,
            'maxPage' => $maxPage,
        ]);
    }

    #[Route('/client/api/telephone', name: 'app_client_api')]
    public function getClientByTelephone(ClientRepository $clientRepository,Request $request): JsonResponse
    {
        $telephone=$request->get('telephone',"");
        return $this->json([
            'datas' => $clientRepository->findOneBySomeField("telephone", $telephone),
            'telephone' => $telephone,
        ]);
    }

    
    #[Route('/client/dettes/{idClient}', name: 'client_dettes')]
    public function clientDettes(Request $request,ClientRepository $clientRepository,DetteRepository $detteRepository,int $idClient): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $statut = $request->query->getString('statut', 2);
        $limit = 4;
        $client=$clientRepository->find($idClient);
        $montant=$detteRepository->getTotalMontant($client->getId());
        $montantVerser=$detteRepository->getTotalMontantVerser($client->getId());
        $dettes=$detteRepository->paginateDettes($page,$limit,$client->getId(),$statut);
        $count = $dettes->count();
        $maxPage = ceil($count / $limit);
        return $this->json([
            'client' => $client,
            'dettes' => $dettes,
            'total'=>$montant,
            'verser'=>$montantVerser,
            'du'=>$montant-$montantVerser,
            'statut'=>$statut,
            'page' => $page,
            'maxPage' => $maxPage,
        ]);
    }

    #[Route('/client/store', name: 'client.store',methods:['GET','POST'])]
    public function store(Request $request,EntityManagerInterface $entityManager): JsonResponse
    {
        $client=new Client();
        $client->setTelephone($request->request->get("telephone"));
        $client->setSurname($request->request->get("surname"));
        $client->setAdresse($request->request->get("adresse"));

        if ($request->query->get("checked")!=0) {
                $compte=new Compte();
                $compte->setLogin($request->query->get("login"));
                $compte->setNom($request->query->get("nom"));
                $compte->setPrenom($request->query->get("prenom"));
                $compte->setPassword($request->query->get("password"));
                $client->setCompte($compte);
                $entityManager->persist($compte);
            }
        $entityManager->persist($client);
        $entityManager->flush(); 
        return $this->json([
            'client' => $client,
            'satatus' => "success",
        ]);
    }
    

    
}
