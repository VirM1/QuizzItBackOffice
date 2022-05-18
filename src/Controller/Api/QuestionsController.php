<?php

namespace App\Controller\Api;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionsController extends AbstractController
{
/*    #[Route('/questions', name: 'app_questions')]
    public function index(): JsonResponse
    {
        return new JsonResponse(null,200);
    }*/

    #[Route('/questions/thematique-{id_thematique}/modules-{id_module}', name: 'api_questions')]
    public function retrieveThematiquesModulesQuestions(QuestionRepository $repo, array $_route_params): JsonResponse {
        $questions = $repo->findQuizzQuestionsByModule($_route_params['id_module']);
        return new JsonResponse($questions);
    }

}
