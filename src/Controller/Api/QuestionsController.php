<?php

namespace App\Controller\Api;

use App\Entity\ModuleThematique;
use App\Entity\Reponse;
use App\Entity\ReponseModuleThematique;
use App\Entity\Utilisateur;
use App\Manager\QuizzManager;
use App\Repository\ModuleThematiqueRepository;
use App\Repository\QuestionRepository;
use App\Repository\ReponseRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionsController extends AbstractController
{
    public function __construct(private QuizzManager $manager){
    }

    #[Route('/questions/modules-{id_module}', name: 'api_questions')]
    public function retrieveThematiquesModulesQuestions(QuestionRepository $repo, array $_route_params): Response {
        return $this->manager->createNewQuizz($_route_params['id_module'], $this->getUser());
    }

    #[Route('/questions/envoyer-reponses', name: 'api_questions_send_answers')]
    public function sendAnswers(Request $request, EntityManagerInterface $em): JsonResponse {
        $datas = json_decode($request->getContent(), true);

        $quizz = $em->getRepository(ReponseModuleThematique::class)
                    ->findOneBy(["module"=>$datas["module-id"], "utilisateur"=>$datas["user-id"], "dateCreation"=>$datas["date-creation"]]);

       foreach ($datas["reponses"] as $reponse) {
           $quizz->addReponses(
               $em ->getRepository(Reponse::class)
                   ->findOneBy(["id"=>$reponse])
           );
       }
       $em->persist($quizz);
       $em->flush();
        return new JsonResponse(null,JsonResponse::HTTP_OK);
    }
}
