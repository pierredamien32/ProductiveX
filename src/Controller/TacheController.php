<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\ProjetRepository;
use App\Repository\TacheRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TacheController extends AbstractController
{
    /**
     *  Cette fonction envoie vers la page entreprise/dashboard/projets.html.twig
     *cette page est la page permet de voir tous les projets et d'en creer d'autre
     * @return Response
     */
    #[Route('/tache/add&list', name: 'app_dashboard_addTache')]
    public function addlisttache(
        Request $request,
        EntityManagerInterface $manager,
        tacheRepository $repoTache,
        ProjetRepository $repoProjet,
        StatusRepository $repoStatus
    ): Response {

        // =============>debut du formulaire de creation 
        $tache = new Tache();
        $entreprise = $this->getUser()->getEntreprise();
        $form = $this->createForm(TacheType::class,$tache,['entreprise' => $entreprise]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $tache = $form->getData();
                
                // Récupérer l'objet Status correspondant à l'état par défaut
                $statusParDefaut = $repoStatus->findOneBy(['nom' => 'À faire']);
                $tache->setStatus($statusParDefaut);
                // dd($tache);

                $manager->persist($tache);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Votre tache a été créé avec succès !'
                );
            } else {
                $this->addFlash(
                    'error',
                    'Une erreur s\'est produite lors de la création du tache.'
                );
            }
        }
        // =============>fin du formulaire de creation 

        // =============>liste des taches
        
        $projets = $repoProjet->findBy(['entreprise' => $this->getUser()->getEntreprise()]);
        $taches = $repoTache->findBy(['projet' => $projets], ['createdAt' => 'DESC']);
        
        // dd($taches);

        return $this->render('entreprise/dashboard/taches.html.twig', [
            'taches' => $taches,
            'form' => $form->createView()
        ]);
    }

    /**
     * Fonction de modification des taches
     */
    // #[Security("is_granted('ROLE_USER') and user === tache.getUser()")]
    #[Route('/tache/edition/{id}', 'tache.edit', methods: ['GET', 'POST'])]
    public function edit(
        tache $tache,
        Request $request,
        TacheRepository $repotache,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(tacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tache = $form->getData();

            $manager->persist($tache);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre tache a été modifié avec succès !'
            );
        }
        $taches = $repotache->findBy(['entreprise' => $this->getUser()->getEntreprise()]);


        return $this->render('entreprise/dashboard/taches.html.twig', [
            'taches' => $taches,
            'form' => $form->createView()
        ]);
    }


    /**
     * Fonction de suppression des taches
     */
    #[Route('/tache/suppression/{id}', name: 'tache.delete', methods: ['GET'])]
    // #[Security("is_granted('ROLE_USER') and user === tache.getEntreprise().getUser()")]
    public function delete(
        EntityManagerInterface $manager,
        Tache $tache
    ): Response {
        $manager->remove($tache);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre tache a été supprimé avec succès !'
        );

        return $this->redirectToRoute('app_dashboard_addTache');
    }
}