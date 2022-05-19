<?php

namespace App\Controller\Admin;

use App\Form\ImportCSVFileAndAssociateType;
use App\Manager\ChartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminStatController extends AbstractController
{
    #[Route('/admin/statOfModule', name: 'app_admin_stats_of_modules')]
    public function index(Request $request,ChartManager $chartManager): Response
    {
        return $this->render('backOffice/statModules.html.twig', array("chart"=>$chartManager->getChartOfModules()));
    }
}
