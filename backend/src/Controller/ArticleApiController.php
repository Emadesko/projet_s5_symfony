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
        $limit = 6;
        $articles=[];
        $libelle=$request->get('libelle',"");
        $articles = $articleRepository->paginateArticles($page,$limit,$libelle);
        $count = $articles->count();
        $maxPage = ceil($count / $limit);
        return $this->json([
            'datas' => $articles,
            'libelle' => $libelle,
            'page' => $page,
            'maxPage' => $maxPage,
        ]);
    }

    #[Route('/article/api/rupture', name: 'app_article_get')]
    public function getArticlesRupture(ArticleRepository $articleRepository, Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $articles=[];
        $libelle=$request->get('libelle',"");
        $qteStock=$request->get('qteStock',10);
        $articles = $articleRepository->articlesRupture($page,$limit,$qteStock,$libelle);
        $count = $articles->count();
        $maxPage = ceil($count / $limit);
        return $this->json([
            'datas' => $articles,
            'qteStock' => $qteStock,
            'libelle' => $libelle,
            'page' => $page,
            'maxPage' => $count,
        ]);
    }

    #[Route('/article/api/dispo', name: 'app_article_get')]
    public function getArticlesDispo(ArticleRepository $articleRepository, Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $articles=[];
        $libelle=$request->get('libelle',"");
        $qteStock=$request->get('qteStock',10);
        $articles = $articleRepository->articlesDispo($page,$limit,$qteStock,$libelle);
        $count = $articles->count();
        $maxPage = ceil($count / $limit);
        return $this->json([
            'datas' => $articles,
            'qteStock' => $qteStock,
            'libelle' => $libelle,
            'page' => $page,
            'maxPage' => $count,
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
