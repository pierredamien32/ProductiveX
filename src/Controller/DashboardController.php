<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/workspace/entreprise')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig');// Cette fonction envoie vers la page dashboard/index.html.twig
                                                        // cette page est la page d'accueil du compte entreprise
    }

    #[Route('/dashboard/hello', name: 'app_dashboard_hello')]
    public function hello(): Response
    {
        return $this->render('dashboard/hello.html.twig');
    }

    #[Route('/dashboard/view-membres', name: 'app_dashboard_viewMembres')]
    public function viewMembres(): Response
    {
        return $this->render('dashboard/employe.html.twig');// Cette fonction envoie vers la page dashboard/employe.html.twig
                                                            // cette page est la page permet de voir tous les membres et d'en creer d'autre
    }
}