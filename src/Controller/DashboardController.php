<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/workspace/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig');
    }

    #[Route('/workspace/dashboard/hello', name: 'app_dashboard_hello')]
    public function hello(): Response
    {
        return $this->render('dashboard/hello.html.twig');
    }

    #[Route('/workspace/dashboard/view-membres', name: 'app_dashboard_viewMembres')]
    public function viewMembres(): Response
    {
        return $this->render('dashboard/employe.html.twig');
    }
}
