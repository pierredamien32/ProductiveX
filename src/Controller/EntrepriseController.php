<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\TacheRepository;
use App\Repository\ProjetRepository;
use App\Repository\StatusRepository;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProjetStatusRepository;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 *  Cette fonction envoie vers la page dashboard/index.html.twig 
 *  cette page est la page d'accueil du compte entreprise 
 */

 #[IsGranted('ROLE_ENT')]
#[Route('/workspace/entreprise')]
class EntrepriseController extends AbstractController
{
    #[Route('/', name: 'app_entreprise')]
    public function index(ProjetStatusRepository $repoprojetstatus,ProjetRepository $repoProjet): Response
    {
        
        // Récupérer l'entreprise de l'utilisateur connecté
        $projets = $repoProjet->findBy(['entreprise' => $this->getUser()->getEntreprise()], ['createdAt' => 'DESC']);

        $projstatus = [];

        foreach ($projets as $projet) {
            $ps = $repoprojetstatus->findBy(['projet' => $projet], ['createdAt' => 'DESC'], 1);
            $firstRecord = count($ps) > 0 ? $ps[0] : null;
            $projstatus[] = $firstRecord;
        }
        



        return $this->render('entreprise/dashboard/index.html.twig', [
                // 'projets' => $projets,
                // 'employes' => $employes
        ]); 
    }
    
   

    // ===========================================================>crud des membres



   
}