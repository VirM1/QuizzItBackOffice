<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Entity\ModuleThematique;
use App\Entity\ReponseModuleThematique;
use App\Manager\ChartManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminStatController extends AbstractController
{
    #[Route('/admin/statOfModules', name: 'app_admin_stats_of_modules')]
    public function statModules(ChartManager $chartManager): Response
    {
        return $this->render('backOffice/statModules.html.twig', array("chart" => $chartManager->getChartOfModules()));
    }

    #[Route('/admin/statQuestion/{id}', name: 'app_admin_stats_question')]
    #[ParamConverter("question", Question::class)]
    public function statQuestion(Question $question, ChartManager $chartManager): Response
    {
        return $this->render('backOffice/statQuestions.html.twig',
            array(
                "chartReussite" => $chartManager->getChartReussite($question),
                "chartReponse" => $chartManager->getChartOfReponse($question)
            )
        );
    }
}
