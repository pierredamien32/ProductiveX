<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\TacheRepository;
use App\Repository\ProjetRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 *  Cette fonction envoie vers la page dashboard/index.html.twig 
 *  cette page est la page d'accueil du compte entreprise 
 */

 #[IsGranted('ROLE_USER')]
#[Route('/workspace/entreprise')]
class EntrepriseController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(ProjetRepository $repository,TacheRepository $repotache ): Response
    {
        // Récupérer l'entreprise de l'utilisateur connecté
        $user = $this->getUser();
        $entreprise = $user->getEntreprise();

        $projets = $repository->findBy(['entreprise' => $entreprise ]); 
        $taches = $repotache->findBy(['projet' => $projets], ['createdAt' => 'DESC']);

        return $this->render('entreprise/dashboard/index.html.twig', [
                'taches' => $taches
        ]); 
    }
    
   

    // ===========================================================>crud des membres



   
}