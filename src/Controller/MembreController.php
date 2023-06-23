<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MembreController extends AbstractController
{
    // #[Route('/membre', name: 'app_membre')]
    // public function index(): Response
    // {
    //     return $this->render('membre/index.html.twig', [
    //         'controller_name' => 'MembreController',
    //     ]);
    // }

    // #Route interface utilisateurs

    #[Route('/dashboard/compte/membre', name: 'app_dashboard_membre')]
    public function dashboard(): Response
    {
        return $this->render('employe/dashboard/index.html.twig');
    }

    #[Route('/dashboard/compte/membre/taches', name: 'app_dashboard_viewTache')]
    public function viewTache(): Response
    {
        return $this->render('employe/dashboard/taches.html.twig');
    }

    #[Route('/dashboard/compte/membre/taches', name: 'app_dashboard_viewNotifs_membre')]
    public function viewNotifs_membre(): Response
    {
        return $this->render('employe/dashboard/notifs.html.twig');
    }

    #[Route('/dashboard/compte/membre/taches', name: 'app_dashboard_viewRappel_membre')]
    public function viewRappel_membre(): Response
    {
        return $this->render('employe/dashboard/rappel.html.twig');
    }

    #[Route('/dashboard/compte/membre/detail-taches', name: 'app_dashboard_viewDetail_tache')]
    public function viewDetail_tache(): Response
    {
        return $this->render('employe/dashboard/detailTache.html.twig');
    }
}
