<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjetController extends AbstractController
{

    
    #[IsGranted('ROLE_USER')]
    #[Route('/projet', name: 'projet.index')]
    public function index(ProjetRepository $repository): Response
    {
        $projets = $repository->findBy(['user' => $this->getUser()]); 
    
        return $this->render('projet/index.html.twig', [
                'projets' => $projets
        ]);
    }

    #[Route('/projet/creation', 'projet.new')]
    #[IsGranted('ROLE_USER')]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $projet = $form->getData();
            $projet->setUser($this->getUser());

            $manager->persist($projet);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre projet a été créé avec succès !'
            );

            return $this->redirectToRoute('projet.index');
        }

        return $this->render('pages/projet/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Security("is_granted('ROLE_USER') and user === projet.getUser()")]
    #[Route('/projet/edition/{id}', 'projet.edit', methods: ['GET', 'POST'])]
    public function edit(
        Projet $projet,
        Request $request,
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

            return $this->redirectToRoute('projet.index');
        }

        return $this->render('pages/projet/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
   
    #[Route('/projet/suppression/{id}', 'projet.delete', methods: ['GET'])]
    #[Security("is_granted('ROLE_USER') and user === projet.getUser()")]
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

        return $this->redirectToRoute('projet.index');
    }
    
}