<?php

namespace App\Controller\Admin;

use App\Entity\ModuleThematique;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\Thematique;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // the name visible to end users
            ->setTitle('QuizzIt!')

            // the path defined in this method is passed to the Twig asset() function
            ->setFaviconPath('favicon.svg')


            // there's no need to define the "text direction" explicitly because
            // its default value is inferred dynamically from the user locale
            ->setTextDirection('ltr')
            // by default, users can select between a "light" and "dark" mode for the
            // backend interface. Call this method if you prefer to disable the "dark"
            // mode for any reason (e.g. if your interface customizations are not ready for it)
            ->disableDarkMode()

            // by default, all backend URLs are generated as absolute URLs. If you
            // need to generate relative URLs instead, call this method
            ->generateRelativeUrls();
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud('Questions', 'fas fa-list', Question::class),
            MenuItem::linkToCrud('Réponses', 'fas fa-list', Reponse::class),
            MenuItem::linkToCrud('Thématiques', 'fas fa-list', Thematique::class),
            MenuItem::linkToCrud("Modules", 'fas fa-list', ModuleThematique::class)
        ];
    }
}
