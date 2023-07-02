<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Projet;
use App\Form\ProjetType;
use App\Entity\ProjetStatus;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentaireController extends AbstractController
{
    // /**
    //  *  Cette fonction envoie vers la page entreprise/dashboard/projets.html.twig
    //  *cette page est la page permet de voir tous les projets et d'en creer d'autre
    //  * @return Response
    //  */
    // #[Route('/projet/add&list', name: 'app_dash_employe_commentaire')]
    // public function addlistProjet(
    //     Request $request,
    //     EntityManagerInterface $manager,
    //     CommentaireRepository $commentaire,
    // ): Response {

    //     // =============>debut du formulaire de creation 
    //     $commentaire = new Commentaire();
    //     $form = $this->createForm(  CommentaireType::class, $commentaire);

    //     $form->handleRequest($request);

    //     if ($form->isSubmitted()) {
    //         if ($form->isValid()) {
    //             $commentaire = $form->getData();
    //             $user = $this->getUser()->getEntreprise(); 
    //             $commentaire->setUserid($user);
                
    //             dd($commentaire);
    //             $manager->persist($commentaire);
   
    //             $manager->flush();

    //         }
    //     }
    //     // =============>fin du formulaire de creation 

    //     // =============>liste des projets

    //     // $commentaire = $commentaire->findBy(['createdAt' => 'DESC']);

    //     $projstatus = [];

    //     return $this->render('employe/dashboard/detailTache.html.twig', [
    //         'commentaire' => $commentaire,
    //         'form' => $form->createView()
    //     ]);
    // }

}