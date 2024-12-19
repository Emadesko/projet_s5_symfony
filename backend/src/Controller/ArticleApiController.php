<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ArticleApiController extends AbstractController
{


    #[Route('/article/api', name: 'app_article_get')]
    public function index(ArticleRepository $articleRepository, Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = 1;
        $articles=[];
        $libelle=$request->get('libelle',"");
        $dispo=$request->get('dispo',"");
        $qteStock=$request->get('qteStock',10);
        $paginator = $articleRepository->paginateArticles($page,$limit,$libelle,$dispo,$qteStock);
        $count = $paginator->count();
        $maxPage = ceil($count / $limit);
        foreach ($paginator as $key => $value) {
            $articles[]= [
                'id' => $value->getId(),
                'libelle' => $value->getLibelle(),
                'prix' => $value->getPrix(),
                'qteStock' => $value->getQteStock(),
                'reference' => $value->getReference(),
            ];
        }
        return $this->json([
            'datas' => $articles,
            'libelle' => $libelle,
            'dispo' => $dispo,
            'qteStock' => $qteStock,
            'page' => $page,
            'maxPage' => $maxPage,
        ]);
    }


    #[Route('/article/create', name: 'app_article_create')]
    public function createUser(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        // Vérifier si les données sont valides
        if (isset($data['name']) && isset($data['email'])) {
            // Traiter les données (par exemple, les enregistrer dans la base de données)
            $name = $data['name'];
            $email = $data['email'];

            // Exemple de retour : envoyer une réponse JSON avec les données reçues
            return new JsonResponse([
                'status' => 'success',
                'name' => $name,
                'email' => $email
            ]);
        }

        // Si les données sont invalides, retourner une erreur
        return new JsonResponse([
            'status' => 'error',
            'message' => 'Données manquantes ou invalides'
        ], 400);
    }
}
