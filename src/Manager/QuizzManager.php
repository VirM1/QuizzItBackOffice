<?php

namespace App\Manager;

use App\Entity\ModuleThematique;
use App\Entity\ReponseModuleThematique;
use App\Entity\Utilisateur;
use App\Repository\QuestionRepository;

use App\Manager\SerializerManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Utils\ReponseDateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class QuizzManager {

    public function __construct(private QuestionRepository $repo, private EntityManagerInterface $em, private SerializerManager $sm)
    {
    }

    public function createNewQuizz (int $idModule, Utilisateur $user) : Response
    {
        $module = $this->em->getRepository(ModuleThematique::class)->findOneBy(["id" => $idModule]);
        $questions = $this->repo->findQuizzQuestionsByModule($idModule);
        $date = new ReponseDateTime();
        $quizz = new ReponseModuleThematique();
        $quizz  ->setDateCreation($date)
                ->setUtilisateur($user)
                ->setModule($module);
        foreach ($questions as $question) {
            $quizz->addQuestion($question);
        }
        $this->em->persist($quizz);
        $this->em->flush();


        $response =  new Response($this->sm->serializeReponseModuleThematique($quizz),JsonResponse::HTTP_OK);
        $response->headers->set("Content-Type","application/json");
        return $response;
    }
}