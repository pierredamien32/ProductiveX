<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/workspace/entreprise')]
class DashboardController extends AbstractController
{
    // #[Route('/dashboard', name: 'app_dashboard')]
    // public function index(): Response
    // {
    //     return $this->render('dashboard/index.html.twig');// Cette fonction envoie vers la page dashboard/index.html.twig
    //                                                     // cette page est la page d'accueil du compte entreprise
    // }

    #[Route('/dashboard/hello', name: 'app_dashboard_hello')]
    public function hello(): Response
    {
        return $this->render('dashboard/hello.html.twig');
    }

    #[Route('/dashboard/view-membres', name: 'app_dashboard_viewMembres')]
    public function viewMembres(): Response
    {
        return $this->render('entreprise/dashboard/membres.html.twig');// Cette fonction envoie vers la page entreprise/dashboard/membres.html.twig
                                                            // cette page est la page permet de voir tous les membres et d'en creer d'autre
    }

    // #[Route('/dashboard/add-projet', name: 'app_dashboard_addProjet')]
    // public function addProjet(): Response
    // {
    //     return $this->render('entreprise/dashboard/projets.html.twig');// Cette fonction envoie vers la page entreprise/dashboard/projets.html.twig
    //                                                         // cette page est la page permet de voir tous les projets et d'en creer d'autre
    // }

    // #[Route('/dashboard/add-tache', name: 'app_dashboard_addTache')]
    // public function addTache(): Response
    // {
    //     return $this->render('entreprise/dashboard/taches.html.twig');// Cette fonction envoie vers la page entreprise/dashboard/taches.html.twig
    //                                                         // cette page est la page permet de voir tous les taches et d'en creer d'autre
    // }

    #[Route('/dashboard/view-notifs', name: 'app_dashboard_viewNotifs')]
    public function viewNotifs(): Response
    {
        return $this->render('entreprise/dashboard/taches.html.twig');// Cette fonction envoie vers la page entreprise/dashboard/taches.html.twig
                                                            // cette page est la page permet de voir tous les notifications
    }

    #[Route('/dashboard/view-rappel', name: 'app_dashboard_viewRappel')]
    public function viewRappel(): Response
    {
        return $this->render('entreprise/dashboard/taches.html.twig');// Cette fonction envoie vers la page entreprise/dashboard/taches.html.twig
                                                            // cette page est la page permet de voir tous les rappels
    }
}