<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[IsGranted('ROLE_ENT')]
#[Route('/workspace/entreprise')]
class EmployeController extends AbstractController
{


    #[Route('/dashboard/view-membres', name: 'app_dashboard_viewMembres')]
    public function addlistmembre(
        Request $request,
        EntityManagerInterface $manager,
        EmployeRepository $repoEmp,

    ): Response {


        // =============>debut du formulaire de creation 

        // $roles = ['ROLE_USER', 'ROLE_ENT'];
        // $user->setRoles($roles);
        // $user->setRoles(['ROLE_USER', 'ROLE_ENT']);
        // $form = $this->createForm(EntrepriseType::class, $entreprise);
        // $form->handleRequest($request);

        $user = new User();
        $employe = new Employe();
        $employe->setUserid($user);
        $roles = ['ROLE_USER', 'ROLE_EMP'];
        $user->setRoles($roles);
        $entreprise = $this->getUser()->getEntreprise();
        $form = $this->createForm(EmployeType::class, $employe);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $employe = $form->getData();

                $employe->setEntreprise($entreprise);

                // dd($employe);

                $image = $form->get('image')->getData();

                if ($image) {
                    // Générez un nom de fichier unique
                    $imageName = md5(uniqid()) . '.' . $image->guessExtension();

                    $image->move(
                        $this->getParameter('image_directory'),
                        $imageName
                    );
                    $employe->setImage($imageName);
                }
                
                $manager->persist($employe);
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Votre nouveau membre a été créé avec succès !'
                );
            } else {
                $this->addFlash(
                    'error',
                    'Une erreur s\'est produite lors de la création du employe.'
                );
            }
        }

        // =============>fin du formulaire de creation 

        // =============>liste des taches

        $employes = $repoEmp->findBy(['entreprise' => $entreprise], ['id' => 'DESC']);

        // dd($employes);

        return $this->render('entreprise/dashboard/membres.html.twig', [
            'employe' => $employes,
            'form' => $form->createView()
        ]);
    }

    /**
     * Fonction de modification des taches
     */
    // #[Security("is_granted('ROLE_USER') and user === employe.getUser()")]
    #[Route('/membre/edition/{id}', 'employe.edit', methods: ['GET', 'POST'])]
    public function edit(
        employe $employe,
        Request $request,
        EmployeRepository $RepoEmploye,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(tacheType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employe = $form->getData();

            $manager->persist($employe);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre employe a été modifié avec succès !'
            );
        }
        $taches = $repotache->findBy(['entreprise' => $this->getUser()->getEntreprise()]);


        return $this->render('employe/entreprise/taches.html.twig', [
            'taches' => $taches,
            'form' => $form->createView()
        ]);
    }

    /**
     * Fonction de suppression des projets
     */
    #[Route('/suppression/{id}', name: 'employe.delete', methods: ['GET'])]
    // #[Security("is_granted('ROLE_USER') and user === Employe.getEntreprise().getUser()")]
    public function delete(
        EntityManagerInterface $manager,
        Employe $employe
    ): Response {
        $manager->remove($employe);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre membre a été supprimé avec succès !'
        );

        return $this->redirectToRoute('app_dashboard_viewMembres');
    }
}