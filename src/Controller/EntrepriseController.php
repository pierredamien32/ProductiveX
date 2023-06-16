<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/workspace/entreprise')]
class EntrepriseController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig'); // Cette fonction envoie vers la page dashboard/index.html.twig
        // cette page est la page d'accueil du compte entreprise
    }
}