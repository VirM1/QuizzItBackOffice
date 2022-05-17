<?php

namespace App\Controller\Admin;

use App\Form\ImportCSVFileAndAssociateType;
use App\Manager\ImportManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminImportController extends AbstractController
{
    #[Route('/admin/import', name: 'app_admin_import')]
    public function index(Request $request,ImportManager $importManager): Response
    {

        $form = $this->createForm(ImportCSVFileAndAssociateType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $importManager->handleFileForQuestions($data["module"],$data["fileImport"]);
            $this->addFlash("success","Fichier traité!");
            return $this->redirectToRoute("dashboard");
        }

        return $this->render('backOffice/import.html.twig', [
            'form' =>$form->createView(),
        ]);
    }
    #[Route('/admin/getTemplate', name: 'app_admin_template')]
    public function getTemplate(ImportManager $importManager): Response
    {
        return $importManager->generateBaseTemplate();
    }
}
