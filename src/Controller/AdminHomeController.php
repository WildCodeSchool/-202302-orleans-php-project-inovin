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
        $dashboardData = $dashboardRepository->find(1);
        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => ['Total'],

            'datasets' => [
                [
                    'barPercentage' => 0.3,
                    'label' => 'Cépages',
                    'backgroundColor' => 'rgba(215, 186, 49, 1)',
                    'borderColor' => 'rgba(242, 234, 191, 1)',
                    'data' => [$dashboardData->getNbrGrapeVarieties()],
                    'layout' => ['padding' => '20'],
                ],
                [
                    'barPercentage' => 0.3,
                    'label' => 'Vins',
                    'backgroundColor' => 'rgba(215, 150, 100, 1)',
                    'borderColor' => 'rgba(242, 234, 191, 1)',
                    'data' => [25],
                    'layout' => ['padding' => '20'],
                ],
                [
                    'barPercentage' => 0.3,
                    'label' => 'Séances',
                    'backgroundColor' => 'rgba(215, 150, 80, 1)',
                    'borderColor' => 'rgba(242, 234, 191, 1)',
                    'data' => [6],
                    'layout' => ['padding' => '20'],
                ],
                [
                    'barPercentage' => 0.3,
                    'label' => 'Utilisateurs',
                    'backgroundColor' => 'rgba(215, 150, 60, 1)',
                    'borderColor' => 'rgba(242, 234, 191, 1)',
                    'data' => [16],
                    'layout' => ['padding' => '20'],
                ],
            ],
        ]);

        $chart->setOptions([
            'maintainAspectRatio' => false,
            'layout' => ['padding' => 5],
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
                    'pointStyle' => false,
                    'labels' => [
                        'usePointStyle' => true,
                        'pointStyleWidth' => 15,
                        'color' => 'rgba(255, 255, 255, 1)',
                        'padding' => 20,
                    ],
                ],
            ],
            'scales' => [
                'xAxes' => [
                    'grid' => [
                        'color' => 'rgba(255, 255, 255, 0.7)'
                    ],
                ],
                'yAxes' => [
                    'grid' => [
                        'color' => 'rgba(255, 255, 255, 0.2)'
                    ],
                ],
            ],
        ]);

        return $this->render('admin/index.html.twig', ['chart' => $chart]);
    }
}
