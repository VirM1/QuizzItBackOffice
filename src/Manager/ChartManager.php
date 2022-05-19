<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartManager
{

    public function __construct(private StatsManager $statsManager,private ChartBuilderInterface $chartBuilder,private EntityManagerInterface $entityManager)
    {
    }

    public function getChartOfModules()
    {
        $modulesWstats = $this->statsManager->getMoyenneOfModules();
        $data = array();
        $labels = array();
        foreach ($modulesWstats as $modulesWstat)
        {
            array_push($data,$modulesWstat["moyenne"]);
            array_push($labels,$modulesWstat["libelle"]);
        }

        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);

        $chart->setData([
            'labels' => $labels,
            'datasets' => [array(
                "label"=>"ModuleThematique",
                "data"=>$data
            )
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 20,
                ],
            ],
        ]);


        return $chart;
    }
}