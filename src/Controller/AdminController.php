<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/home/admin', name: 'app_admin')]
    public function homeAdmin(): Response
    {
        return $this->render('admin/index.html.twig');// Cette fonction envoie vers la page admin/index.html.twig
                                                    // cette page est la page d'accueil d'un admin
    }

    #[Route('/home/add-admin', name: 'app_form_admin')]
    public function formAdmin(): Response
    {
        return $this->render('admin/addAdmin.html.twig');// Cette fonction envoie vers la page admin/addAdmin.html.twig
                                                        // cette page est la page permet de voir tous les admins et d'en creer d'autre
    }
    
}
