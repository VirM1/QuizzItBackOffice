<?php

namespace App\Manager;

use App\Entity\ReponseModuleThematique;
use App\Entity\Reponse;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\QueryBuilder;

class StatsManager{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function getMoyenneOfModules()
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('moyenne', 'moyenne');
        $rsm->addScalarResult('libelle', 'libelle');

        //DQL
        $average = $this->entityManager->createNativeQuery(sprintf("SELECT AVG(counts.counting) as moyenne, counts.libelle from (%s) as counts group by counts.ids",
        "SELECT COUNT(*) as counting,reponse_module_thematique.module_id as ids,module_thematique.libelle_module_thematique as libelle FROM reponse_module_thematique
            INNER JOIN questions_reponse_module_thematique on 
            questions_reponse_module_thematique.utilisateur_id =  reponse_module_thematique.utilisateur_id AND 
            questions_reponse_module_thematique.date_creation = reponse_module_thematique.date_creation AND
            questions_reponse_module_thematique.module_id = reponse_module_thematique.module_id
            INNER JOIN reponses_reponse_module_thematique on 
            reponses_reponse_module_thematique.utilisateur_id =  reponse_module_thematique.utilisateur_id AND 
            reponses_reponse_module_thematique.date_creation = reponse_module_thematique.date_creation AND
            reponses_reponse_module_thematique.module_id = reponse_module_thematique.module_id
            INNER JOIN question ON question.id = questions_reponse_module_thematique.question_id
            INNER JOIN module_thematique ON module_thematique.id = reponse_module_thematique.module_id
            WHERE reponses_reponse_module_thematique.reponse_id = question.bonne_reponse_id
            GROUP BY reponse_module_thematique.module_id,reponse_module_thematique.utilisateur_id,reponse_module_thematique.date_creation"
        ),$rsm)->getResult();
        return $average;
    }


    public function getCountOfQuestion(Question $question)
    {
        return $this->entityManager->getRepository(Reponse::class)->findCountForReponse($question);
    }


    public function getTauxReussiteQuestion(Question $question)
    {
        $repo = $this->entityManager->getRepository(Question::class);

        $countAll = $repo->countAllRelations($question);
        $countRight = $repo->countRightRelations($question);
        return array("fausses"=>$countAll[0][1]-$countRight[0][1],"justes"=>$countRight[0][1]);
    }
}