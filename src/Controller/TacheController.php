<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Form\TacheType;
use App\Entity\TacheStatus;
use App\Repository\TacheRepository;
use App\Repository\ProjetRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TacheStatusRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TacheController extends AbstractController
{
    /**
     *  Cette fonction envoie vers la page entreprise/dashboard/taches.html.twig
     *cette page est la page permet de voir tous les taches et d'en creer d'autre
     * @return Response
     */
    #[Route('/tache/add&list', name: 'app_dashboard_addTache')]
    public function addlisttache(
        Request $request,
        EntityManagerInterface $manager,
        tacheRepository $repoTache,
        ProjetRepository $repoProjet,
        StatusRepository $repoStatus,
        TacheStatusRepository $repotachestatus
    ): Response {

        // =============>debut du formulaire de creation 
        $tache = new Tache();
        $tache->setNote(0);
        $entreprise = $this->getUser()->getEntreprise();
        $form = $this->createForm(TacheType::class,$tache,['entreprise' => $entreprise]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $tache = $form->getData();


                // Enregistrement du status par defaut
                $statusParDefaut = $repoStatus->findOneBy(['nom' => 'À faire']);

                $tacheStatus = new TacheStatus();
                $tacheStatus->settache($tache);
                $tacheStatus->setStatus($statusParDefaut);
                // dd($tacheStatus);

                $manager->persist($tache);
                $manager->persist($tacheStatus);
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

        $projets = $repoProjet->findBy(['entreprise' => $this->getUser()->getEntreprise()], ['createdAt' => 'DESC']);
        $taches = $repoTache->findBy(['projet' => $projets], ['createdAt' => 'DESC']);

        $tachestatus = [];

        foreach ($taches as $tache) {
            $ps = $repotachestatus->findBy(['tache' => $tache], ['createdAt' => 'DESC'], 1);
            $firstRecord = count($ps) > 0 ? $ps[0] : null;
            $tachestatus[] = $firstRecord;
        }

        return $this->render('entreprise/dashboard/taches.html.twig', [
            'tachestatus' => $tachestatus,
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

    
    
    #[Route('/dashboard/view/detail-tache/{id}', name: 'app_dashboard_viewDetail_tache_employeur', methods: ['GET'])]
    public function viewDetail_tache(EntityManagerInterface $manager, TacheStatus $ts): Response
    {
        $ts = $manager->getRepository(TacheStatus::class)->find($ts);
        // dd($ts);
        return $this->render('entreprise/dashboard/detailTache.html.twig',[
            'ts' => $ts
        ]); 
    }
}