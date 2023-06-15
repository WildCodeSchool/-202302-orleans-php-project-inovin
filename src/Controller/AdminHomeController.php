<?php

namespace App\Controller;

use App\Repository\AdminDashboardRepository;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: 'app_admin_')]
class AdminHomeController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(AdminDashboardRepository $dashboardRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $datasets =  $barsData = $barsBgColor = [];
        $keyLabels = ['grapes' => 'Cépages', 'users' => 'Utilisateurs', 'wines' => 'Vins', 'sessions' => 'Séances'];

        $dashboardData = $dashboardRepository->getDashboardCountData();
        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);

        foreach ($dashboardData as $key => $value) {
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

        return $this->render('admin/index.html.twig', ['chart' => $chart]);
    }
}
