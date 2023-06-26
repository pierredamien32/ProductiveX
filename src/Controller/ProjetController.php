<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Projet;
use App\Form\ProjetType;
use App\Entity\ProjetStatus;
use Doctrine\ORM\Query\Expr\Join;
use App\Repository\ProjetRepository;
use App\Repository\ProjetStatusRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 #[IsGranted('ROLE_ENT')]
#[Route('/workspace/entreprise')]
class ProjetController extends AbstractController
{


    /**
     *  Cette fonction envoie vers la page entreprise/dashboard/projets.html.twig
     *cette page est la page permet de voir tous les projets et d'en creer d'autre
     * @return Response
     */
    #[Route('/projet/add&list', name: 'app_dashboard_addProjet')]
    public function addlistProjet(
        Request $request,
        EntityManagerInterface $manager,
        ProjetRepository $repoProjet,
        ProjetStatusRepository $repoprojetstatus,
        StatusRepository $repoStatus
    ): Response {

        // =============>debut du formulaire de creation 
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $projet = $form->getData();
                $projet->setEntreprise($this->getUser()->getEntreprise());


                // Enregistrement du status par defaut
                $statusParDefaut = $repoStatus->findOneBy(['nom' => 'À faire']);

                $projetStatus = new ProjetStatus();
                $projetStatus->setProjet($projet);
                $projetStatus->setStatus($statusParDefaut);     
                // dd($projetStatus);
                
                $manager->persist($projet);
                $manager->persist($projetStatus);
   
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Votre projet a été créé avec succès !'
                );
            } else {
                $this->addFlash(
                    'error',
                    'Une erreur s\'est produite lors de la création du projet.'
                );
            }
        }
        // =============>fin du formulaire de creation 

        // =============>liste des projets

        $projets = $repoProjet->findBy(['entreprise' => $this->getUser()->getEntreprise()], ['createdAt' => 'DESC']);

        $projstatus = [];

        foreach ($projets as $projet) {
            $ps = $repoprojetstatus->findBy(['projet' => $projet], ['createdAt' => 'DESC'], 1);
            $firstRecord = count($ps) > 0 ? $ps[0] : null;
            $projstatus[] = $firstRecord;    
    
        }
        return $this->render('entreprise/dashboard/projets.html.twig', [
            'projstatus' => $projstatus,
            'form' => $form->createView()
        ]);
    }

    /**
     * Fonction de modification des projets
     */
    // #[Security("is_granted('ROLE_USER') and user === projet.getUser()")]
    #[Route('/projet/edition/{id}', 'projet.edit', methods: ['GET', 'POST'])]
    public function editProjet(
        Projet $projet,
        Request $request,
        ProjetRepository $repoProjet,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projet = $form->getData();

            $manager->persist($projet);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre projet a été modifié avec succès !'
            );
        }
        $projets = $repoProjet->findBy(['entreprise' => $this->getUser()->getEntreprise()]);


        return $this->render('entreprise/dashboard/projets.html.twig', [
            'projets' => $projets,
            'form' => $form->createView()
        ]);
    }


    /**
     * Fonction de suppression des projets
     */
    #[Route('/projet/suppression/{id}', name: 'projet.delete', methods: ['GET'])]
    // #[Security("is_granted('ROLE_USER') and user === projet.getEntreprise().getUser()")]
    public function delete(
        EntityManagerInterface $manager,
        Projet $projet
    ): Response {
        $manager->remove($projet);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre projet a été supprimé avec succès !'
        );

        return $this->redirectToRoute('app_dashboard_addProjet');
    }

    
}