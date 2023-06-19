<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Repository\ProjetRepository;
use App\Repository\TacheRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 *  Cette fonction envoie vers la page dashboard/index.html.twig 
 *  cette page est la page d'accueil du compte entreprise 
 */
#[Route('/workspace/entreprise')]
class EntrepriseController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(ProjetRepository $repository,TacheRepository $repotache ): Response
    {
        // Récupérer l'entreprise de l'utilisateur connecté
        $user = $this->getUser();
        $entreprise = $user->getEntreprise();

        $projets = $repository->findBy(['entreprise' => $entreprise ]); 
        $taches = $repotache->findBy(['projet' => $projets], ['status' => 'ASC']);

        return $this->render('entreprise/dashboard/index.html.twig', [
                'taches' => $taches
        ]); 
    }
}