<?php

namespace App\Controller\Admin;

use App\Entity\ModuleThematique;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\Thematique;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;



class DashboardController extends AbstractDashboardController
{
    public function __construct(private ChartBuilderInterface $chartBuilder)
    {

    }

    public function index(): Response
    {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $this->render('backOffice/dashboard.html.twig',array("chart"=>$chart));
    }


    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addWebpackEncoreEntry('app');
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
            MenuItem::linkToDashboard('dashboard.item.dashboard', 'fa fa-home'),

            MenuItem::section("dashboard.section.user"),
            MenuItem::linkToCrud("dashboard.item.user","fa fa-user",Utilisateur::class),


            MenuItem::section("dashboard.section.cats"),
            MenuItem::linkToCrud('dashboard.item.thematique', "fa-solid fa-table-cells-large", Thematique::class),
            MenuItem::linkToCrud("dashboard.item.modules", "fa-solid fa-table-cells", ModuleThematique::class),

            MenuItem::section("dashboard.section.questions"),
            MenuItem::linkToCrud('dashboard.item.question', 'fa fa-question', Question::class),
            MenuItem::linkToCrud('dashboard.item.reponse', 'fa fa-exclamation', Reponse::class),

            MenuItem::section("dashboard.section.import"),
            MenuItem::linktoRoute("dashboard.item.importFile", 'fa fa-chart-bar', 'app_admin_import'),
        ];
    }
}
