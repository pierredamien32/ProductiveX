<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Entity\TacheStatus;
use App\Repository\TacheRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TacheStatusRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_EMP')]
class MembreController extends AbstractController
{

    #[Route('/dashboard/compte/membre', name: 'app_dashboard_membre')]
    public function dashboard(): Response
    {
        
        return $this->render('employe/dashboard/index.html.twig');
    }

    #[Route('/dashboard/compte/membre/taches', name: 'app_dashboard_viewTache')]
    public function viewTache(
        TacheStatusRepository $repostatustache,
        TacheRepository $repotache,

     ): Response
    {
        $user = $this->getUser()->getEmploye();
        
        $tache = $repotache->findBy(['employe' => $user]);

        $tachestatus = [];

        foreach ($tache as $tache) {
            $ts = $repostatustache->findBy(['tache' => $tache], ['createdAt' => 'DESC'], 1);
            $firstRecord = count($ts) > 0 ? $ts[0] : null;
            $tachestatus[] = $firstRecord;
        }
        // $ts = $repostatustache->findBy(['tache' => $tache]);
        
        return $this->render('employe/dashboard/taches.html.twig',[
            'tachestatus' => $tachestatus
        ]);
    }

    #[Route('/dashboard/compte/membre/taches/changestatus{id}', name: 'app_change_status')]
    public function ChangeStatus(EntityManagerInterface $manager,$id,StatusRepository $repoStatus): Response
    {
        $ts = new TacheStatus();

        $tachestatus = $manager->getRepository(TacheStatus::class)->find($id);
        $tacheid = $tachestatus->getTache();
        // dd($tachestatus->getStatus()->getNom());
        if($tachestatus->getStatus()->getNom() == 'A faire'){
            
            $statusid = $repoStatus->findOneBy(['nom' => 'En cours']);
            $ts->setStatus($statusid);
            $ts->setTache($tacheid);
            $manager->persist($ts);
            $this->addFlash(
                'success',
                'Votre projet a été demarrer avec succès !'
            );
            
        }elseif($tachestatus->getStatus()->getNom() == 'En cours' || $tachestatus->getStatus()->getNom() == 'En retard'){

            $statusid = $repoStatus->findOneBy(['nom' => 'Terminé']);
            $ts->setStatus($statusid);
            $ts->setTache($tacheid);
            $manager->persist($ts);
            $this->addFlash(
                'success',
                'Votre projet est terminer !'
            );
            
        }

        
        $manager->flush();
        return $this->redirectToRoute('app_dashboard_viewTache');
    }
 

    #[Route('/dashboard/compte/membre/taches', name: 'app_dashboard_viewNotifs_membre')]
    public function viewNotifs_membre(): Response
    {
        return $this->render('employe/dashboard/notifs.html.twig');
    }

    #[Route('/dashboard/compte/membre/taches', name: 'app_dashboard_viewRappel_membre')]
    public function viewRappel_membre(): Response
    {
        return $this->render('employe/dashboard/rappel.html.twig');
    }

    #[Route('/dashboard/compte/membre/detail-taches', name: 'app_dashboard_viewDetail_tache')]
    public function viewDetail_tache(): Response
    {
        return $this->render('employe/dashboard/detailTache.html.twig');
    }
}