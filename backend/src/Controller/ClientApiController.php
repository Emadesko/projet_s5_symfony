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
    #[Route('/client/api', name: 'app_client_api' , methods:['GET'])]
    public function index(ClientRepository $clientRepository,Request $request,DetteRepository $detteRepository): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = 1;
        $clients=[];
        $telephone=$request->get('telephone',"");
        $paginator = $clientRepository->paginateClients($page,$limit,$telephone);
        $count = $paginator->count();
        $maxPage = ceil($count / $limit);
        foreach ($paginator as $key => $value) {
            $clients[]= [
                'id' => $value->getId(),
                'surname' => $value->getSurname(),
                'telephone' => $value->getTelephone(),
                'adresse' => $value->getAdresse(),
                'compte' => $value->getCompte()?[
                        'id' => $value->getCompte()->getId(),
                        'role' => $value->getCompte()->getRole()->name,
                        'isActive' => $value->getCompte()->isActive(),
                        'email' => $value->getCompte()->getEmail(),
                        'password' => $value->getCompte()->getPassword(),
                        'prenom' => $value->getCompte()->getPrenom(),
                        'nom' => $value->getCompte()->getNom(),
                        'login' => $value->getCompte()->getLogin()
                    ]:null,
                'montant' => $detteRepository->getTotalMontant($value->getId()),
                'montantVerser' => $detteRepository->getTotalMontantVerser($value->getId())
                
            ];
        }
        return $this->json([
            'datas' =>$clients,
            'telephone' => $telephone,
            'page' => $page,
            'maxPage' => $maxPage,
        ]);
    }

    #[Route('/client/api/tel', name: 'client_telephone_api')]
    public function getClientByTelephone(ClientRepository $clientRepository,Request $request, DetteRepository $detteRepository): JsonResponse
    {
        $telephone=$request->get('telephone',"");
        $value = $clientRepository->findOneBySomeField("telephone", $telephone);
        if ($value){
            $client = [
                'id' => $value->getId(),
                'surname' => $value->getSurname(),
                'telephone' => $value->getTelephone(),
                'adresse' => $value->getAdresse(),
                'compte' => $value->getCompte()?[
                        'id' => $value->getCompte()->getId(),
                        'role' => $value->getCompte()->getRole()->name,
                        'isActive' => $value->getCompte()->isActive(),
                        'email' => $value->getCompte()->getEmail(),
                        'password' => $value->getCompte()->getPassword(),
                        'prenom' => $value->getCompte()->getPrenom(),
                        'nom' => $value->getCompte()->getNom(),
                        'login' => $value->getCompte()->getLogin()
                    ]:null,
                'montant' => $detteRepository->getTotalMontant($value->getId()),
                'montantVerser' => $detteRepository->getTotalMontantVerser($value->getId())
                
            ];
        }else{
            $client = null;
        }
        return $this->json([
            'datas' => $client,
            'telephone' => $telephone,
        ]);
    }
    #[Route('/client/api/surname', name: 'client_surname_api')]
    public function getClientBySurname(ClientRepository $clientRepository,Request $request, DetteRepository $detteRepository): JsonResponse
    {
        $surname=$request->get('surname',"");
        $value = $clientRepository->findOneBySomeField("surname", $surname);
        if ($value){
            $client = [
                'id' => $value->getId(),
                'surname' => $value->getSurname(),
                'telephone' => $value->getTelephone(),
                'adresse' => $value->getAdresse(),
                'compte' => $value->getCompte()?[
                        'id' => $value->getCompte()->getId(),
                        'role' => $value->getCompte()->getRole()->name,
                        'isActive' => $value->getCompte()->isActive(),
                        'email' => $value->getCompte()->getEmail(),
                        'password' => $value->getCompte()->getPassword(),
                        'prenom' => $value->getCompte()->getPrenom(),
                        'nom' => $value->getCompte()->getNom(),
                        'login' => $value->getCompte()->getLogin()
                    ]:null,
                'montant' => $detteRepository->getTotalMontant($value->getId()),
                'montantVerser' => $detteRepository->getTotalMontantVerser($value->getId())
                
            ];
        }else{
            $client = null;
        }
        return $this->json([
            'datas' => $client,
            'surname' => $surname,
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

    #[Route('/client/create', name: 'app_client_create')]
    public function createClient(Request $request,EntityManagerInterface $entityManager)
    {
        $datas = json_decode($request->getContent(), true);
        $client=new Client();
        $client->setTelephone($datas["telephone"]);
        // $client->setSurname($datas["surname"]);
        // $client->setAdresse($datas["adresse"]);

        // if ($datas["checked"]!=0) {
        //         $compte=new Compte();
        //         $compte->setLogin($datas["login"]);
        //         $compte->setNom($datas["nom"]);
        //         $compte->setPrenom($datas["prenom"]);
        //         $compte->setPassword($datas["password"]);
        //         $client->setCompte($compte);
        //     }
        // $entityManager->persist($client);
        // $entityManager->flush(); 
        return new JsonResponse([
            'status' => 'error',
            'message' => 'Données manquantes ou invalides'
        ], 400);
    }
    

    
}
