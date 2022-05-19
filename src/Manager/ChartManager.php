<?php

namespace App\Manager;

use App\Entity\Question;
use App\Entity\Reponse;
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

        [$data,$labels,$colors] = $this->formatList($modulesWstats,"moyenne","libelle");

        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);

        $chart->setData([
            'labels' => $labels,
            'datasets' => [array(
                "backgroundColor"=>$colors,
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

    public function getChartReussite(Question $question)
    {
        $questionStats = $this->statsManager->getTauxReussiteQuestion($question);

        $colors = array();
        foreach ($questionStats as $questionStat)
        {
            array_push($colors,$this->rand_color());
        }

        $chart = $this->chartBuilder->createChart(Chart::TYPE_PIE);

        $chart->setData([
            'labels' => array("fausses","justes"),
            'datasets' => [array(
                "label"=>"Taux de réussite pour la question",
                "data"=>array_values($questionStats),
                "backgroundColor"=>$colors,
                "borderColor"=> 'rgba(200, 200, 200, 0.75)',
                "hoverBorderColor"=> 'rgba(200, 200, 200, 1)',
            )
            ],
        ]);

        return $chart;
    }

    public function getChartOfReponse(Question $question)
    {

        $reponsesStats = $this->statsManager->getCountOfQuestion($question);


        [$data,$labels,$colors] = $this->formatList($reponsesStats,"selectedCounts","libelles");


        $chart = $this->chartBuilder->createChart(Chart::TYPE_DOUGHNUT);

        $chart->setData([
            'labels' => $labels,
            'datasets' => [array(
                "label"=>"Taux de réponse",
                "backgroundColor"=>$colors,
                "borderColor"=> 'rgba(200, 200, 200, 0.75)',
                "hoverBorderColor"=> 'rgba(200, 200, 200, 1)',
                "data"=>$data
            )
            ],
        ]);

        return $chart;
    }

    private function formatList(array $lists,string $countString,string $libelle)
    {
        $data = array();
        $labels = array();
        $colors = array();
        foreach ($lists as $list)
        {
            array_push($data,$list[$countString]);
            array_push($labels,$list[$libelle]);
            array_push($colors,$this->rand_color());
        }

        return array($data,$labels,$colors);
    }

    private function rand_color() {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}