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
        $dashboardData = $dashboardRepository->getDashboardData();

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);

        $chart->setData([
            'labels' => [
                'Nbr Cépages ' . $dashboardData['grapes'],
            ],
            'datasets' => [
                [
                    'barPercentage' => 0.3,
                    'barThickness' => 50,
                    'maxBarThickness' => 75,
                    'minBarLength' => 10,
                    'font' => 'white',
                    'label' => 'Cépages',
                    'backgroundColor' => 'rgba(215, 186, 49, 1)',
                    'borderColor' => 'rgba(242, 234, 191, 1)',
                    'data' => [$dashboardData['grapes']],
                    'layout' => ['padding' => '20'],
                ],
            ],
        ]);

        $chart->setOptions([
            'maintainAspectRatio' => false,
            'layout' => [
                'padding' => 5,
            ],
            'elements' => [
                'bar' => [
                    'borderColor' => 'rgba(242, 234, 191, 1)',
                    'borderWidth' => 3,
                    'backgroundColor' => 'rgba(255, 255, 255, 1)',
                    'borderRadius' => 15,
                    'pointStyle' => 'circle',
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'padding' => 20,
                    'position' => 'right',
                    'pointStyle' => 'circle',
                    'labels' => [
                        'color' => 'white',
                        'usePointStyle' => true,
                        'pointStyleWidth' => 25,
                        'padding' => 20,
                        'font' => ['size' => 18],
                    ],
                ],
            ],
            'scales' => [
                'xAxes' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(255, 255, 255, 0.5)',
                        'tickColor' => 'white'
                    ],
                    'ticks' => [
                        'padding' => 30,
                        'color' => 'white',
                        'font' => ['size' => 16],
                    ],
                ],
                'yAxes' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(255, 255, 255, 0.05)',
                        'tickColor' => 'white'
                    ],
                    'ticks' => [
                        'color' => 'white',
                        'font' => ['size' => 16],
                    ],
                ],
            ],
            'animations' => [
                'borderWidth' => [
                    'duration' => 500,
                    'easing' => 'linear',
                    'from' => 2,
                    'to' => 6,
                    'loop' => true
                ],
            ],
        ]);

        return $this->render('admin/index.html.twig', ['chart' => $chart]);
    }
}
