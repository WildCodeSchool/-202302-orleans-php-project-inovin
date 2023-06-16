<?php

namespace App\Service;

use App\Repository\GrapeVarietyRepository;
use App\Repository\SessionRepository;
use App\Repository\UserRepository;
use App\Repository\WineRepository;
use Container0sIfSOS\getDataCollector_Request_SessionCollectorService;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class AdminDashboardService
{
    private array $data = [];

    public function __construct(
        private GrapeVarietyRepository $grapeRepository,
        private WineRepository $wineRepository,
        private SessionRepository $sessionRepository,
        private UserRepository $userRepository,
        private ChartBuilderInterface $chartBuilder,
    ) {
    }

    public function getDashboardChart(): Chart
    {
        $this->getDashBoardData();
        return $this->buildChartDashboard();
    }


    private function getDashBoardData(): void
    {
        $grapes = $this->grapeRepository->getCount();
        $users = $this->userRepository->getCount();
        $wines = $this->wineRepository->getCount();
        $sessions = $this->sessionRepository->getdCount();
        $this->setData(['grapes' => $grapes, 'users' => $users, 'wines' => $wines, 'sessions' => $sessions]);
    }

    private function buildChartDashboard(): Chart
    {
        $datasets =  $barsData = $barsBgColor = [];
        $keyLabels = ['grapes' => 'Cépages', 'users' => 'Utilisateurs', 'wines' => 'Vins', 'sessions' => 'Séances'];

        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);

        foreach ($this->getData() as $key => $value) {
            $barsData[] =  ['x' => 'Nbr ' . $keyLabels[$key] . ' ' . $value, 'y' => $value];
        }
        $barsBgColor = [
            'rgba(215, 186 , 49, 0.5)',
            'rgba(210, 150 , 49, 0.5)',
            'rgba(221, 120 , 49, 0.5)',
            'rgba(150, 100 , 49, 0.5)',
        ];

        $datasets[] = [
            'data' => $barsData,
            'barPercentage' => 0.4,
            'minBarLength' => 2,
            'font' => 'white',
            'backgroundColor' => $barsBgColor,
            'borderColor' => 'rgba(242, 234, 191, 1)',
            'layout' => ['padding' => '20'],
        ];

        $chart->setData(
            [
                'labels' => [],
                'datasets' => $datasets
            ]
        );

        $chart->setOptions([
            'responsive' => true,
            'maintainAspectRatio' => false,
            'layout' => [
                'padding' => 0,
            ],
            'elements' => [
                'bar' => [
                    'borderColor' => 'rgba(242, 234, 191, 1)',
                    'borderWidth' => 2,
                    'backgroundColor' => 'rgba(255, 255, 255, 1)',
                    'borderRadius' => 8,
                    'pointStyle' => 'circle',
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                    'padding' => 0,
                    'position' => 'right',
                    'pointStyle' => 'circle',
                    'labels' => [
                        'color' => 'white',
                        'usePointStyle' => true,
                        'pointStyleWidth' => 25,
                        'padding' => 15,
                        'font' => ['size' => 18],
                    ],
                ],
            ],
            'scales' => [
                'xAxes' => [
                    'display' => true,
                    'ticks' => [
                        'padding' => 1,
                        'color' => 'white',
                        'font' => ['size' => 12],
                    ],
                ],
                'yAxes' => [
                    'grid' => [
                        'color' => 'rgba(255, 255, 255, 0.08)',
                        'tickColor' => 'rgba(255, 255, 255, 0.08)'
                    ],
                    'ticks' => [
                        'color' => 'white',
                        'font' => ['size' => 16],
                    ],
                ],
            ],
        ]);
        return $chart;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }
}
