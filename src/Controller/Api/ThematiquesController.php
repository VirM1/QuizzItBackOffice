<?php

namespace App\Controller\Api;

use App\Repository\ModuleThematiqueRepository;
use App\Repository\QuestionRepository;
use App\Repository\ThematiqueRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThematiquesController extends AbstractController
{
    #[Route('/thematiques', name: 'api_thematiques')]
    public function retrieveThematiques(ThematiqueRepository $repo): JsonResponse {
        $thematiques = $repo->findAll();
        return new JsonResponse($thematiques);
    }
}
