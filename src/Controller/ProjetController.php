<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProjetController extends AbstractController
{


    /**
     *  Cette fonction envoie vers la page entreprise/dashboard/projets.html.twig
     *cette page est la page permet de voir tous les projets et d'en creer d'autre
     * @return Response
     */
    #[Route('/workspace/entreprise/projet/add&list', name: 'app_dashboard_addProjet')]
    public function addlistProjet(
        Request $request,
        EntityManagerInterface $manager,
        ProjetRepository $repoProjet,
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

                // Récupérer l'objet Status correspondant à l'état par défaut
                $statusParDefaut = $repoStatus->findOneBy(['nom' => 'À faire']);
                $projet->setStatus($statusParDefaut);
                // dd($projet);

                $manager->persist($projet);
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
        // $projets = $repoProjet->findBy(['entreprise' => 2]);
        $projets = $repoProjet->findBy(['entreprise' => $this->getUser()->getEntreprise()], ['createdAt' => 'DESC']);

        return $this->render('entreprise/dashboard/projets.html.twig', [
            'projets' => $projets,
            'form' => $form->createView()
        ]);
    }

    /**
     * Fonction de modification des projets
     */
    // #[Security("is_granted('ROLE_USER') and user === projet.getUser()")]
    #[Route('/workspace/entreprise/projet/edition/{id}', 'projet.edit', methods: ['GET', 'POST'])]
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
    #[Route('/workspace/entreprise/projet/suppression/{id}', name: 'projet.delete', methods: ['GET'])]
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