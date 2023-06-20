<?php

namespace App\Controller;

use App\Service\AdminDashboardService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: 'app_admin_')]
class AdminHomeController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(AdminDashboardService $adminDashBoardSrv): Response
    {
        $chart = $adminDashBoardSrv->getDashboardChart();
        return $this->render('admin/index.html.twig', ['chart' => $chart]);
    }
}
