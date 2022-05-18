<?php

namespace App\Controller\Api;

use App\Repository\ModuleThematiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModulesController extends AbstractController
{
    #[Route('/modules/{id_thematique}/', name: 'api__modules')]
    public function retrieveThematiquesModules(ModuleThematiqueRepository $repo, array $_route_params): JsonResponse {
        $modules = $repo->findAllByThematiqueId($_route_params['id_thematique']);
        return new JsonResponse($modules);
    }
}
