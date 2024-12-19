<?php

namespace App\Controller;

use App\Repository\CompteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CompteApiController extends AbstractController
{
    #[Route('/compte/api', name: 'app_compte_api')]
    public function index(CompteRepository $compteRepository, Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $comptes=[];
        $role=$request->get('role',-1);
        $paginator = $compteRepository->paginateComptes($page,$limit,$role);
        $count = $paginator->count();
        $maxPage = ceil($count / $limit);
        foreach ($paginator as $key => $value) {
            $comptes[]= [
                        'id' => $value->getId(),
                        'role' => $value->getRole()->name,
                        'isActive' => $value->isActive(),
                        'email' => $value->getEmail(),
                        'password' => $value->getPassword(),
                        'prenom' => $value->getPrenom(),
                        'nom' => $value->getNom(),
                        'login' => $value->getLogin()
                    ];
        }
        return $this->json([
            'datas' =>$comptes,
            'role' => $role,
            'page' => $page,
            'maxPage' => $maxPage,
        ]);
    }

    #[Route('/compte/api/login', name: 'compte_login_api')]
    public function getCompteByLogin(CompteRepository $compteRepository,Request $request): JsonResponse
    {
        $login=$request->get('login',"");
        $value = $compteRepository->findOneBySomeField("login", $login);
        if ($value){
            $compte = [
                        'id' => $value->getId(),
                        'role' => $value->getRole()->name,
                        'isActive' => $value->isActive(),
                        'email' => $value->getEmail(),
                        'password' => $value->getPassword(),
                        'prenom' => $value->getPrenom(),
                        'nom' => $value->getNom(),
                        'login' => $value->getLogin()
            ];
        }else{
            $compte = null;
        }
        return $this->json([
            'datas' => $compte,
            'login' => $login,
        ]);
    }

    #[Route('/compte/api/email', name: 'compte_email_api')]
    public function getCompteByEmail(CompteRepository $compteRepository,Request $request): JsonResponse
    {
        $email=$request->get('email',"");
        $value = $compteRepository->findOneBySomeField("email", $email);
        if ($value){
            $compte = [
                        'id' => $value->getId(),
                        'role' => $value->getRole()->name,
                        'isActive' => $value->isActive(),
                        'email' => $value->getEmail(),
                        'password' => $value->getPassword(),
                        'prenom' => $value->getPrenom(),
                        'nom' => $value->getNom(),
                        'login' => $value->getLogin()
            ];
        }else{
            $compte = null;
        }
        return $this->json([
            'datas' => $compte,
            'email' => $email,
        ]);
    }
}
