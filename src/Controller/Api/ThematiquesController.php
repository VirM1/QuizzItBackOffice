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
    #[Route('/thematiques-modules', name: 'api_thematiques_modules')]
    public function retrieveThematiques(ThematiqueRepository $repo, ModuleThematiqueRepository $mrepo): JsonResponse {
        $result = array();
        foreach ($repo->findAllRaw() as $thematique) {
            array_push($result, array($thematique, $mrepo->findAllByThematiqueId($thematique['id'])));
        }
        return new JsonResponse($result);
    }
}
