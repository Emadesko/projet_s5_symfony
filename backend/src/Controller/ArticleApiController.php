<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ArticleApiController extends AbstractController
{
    #[Route('/article/api', name: 'app_article_api')]
    public function index(ArticleRepository $articleRepository): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ArticleApiController.php',
            'datas' => $articleRepository->findAll(),
        ]);
    }
}
