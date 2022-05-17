<?php

namespace App\Controller\Admin;

use App\Form\ImportCSVFileAndAssociateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminImportController extends AbstractController
{
    #[Route('/admin/import', name: 'app_admin_import')]
    public function index(Request $request): Response
    {

        $form = $this->createForm(ImportCSVFileAndAssociateType::class);
        $form->handleRequest($request);

        return $this->render('backOffice/import.html.twig', [
            'form' =>$form->createView(),
        ]);
    }
}
