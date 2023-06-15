<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    // #[Route('/blog', name: 'app_blog')]
    // public function index(): Response
    // {
    //     return $this->render('blog/index.html.twig', [
    //         'controller_name' => 'BlogController',
    //     ]);
    // }

    #[Route('/', name: 'app_blog_home')]
    public function indexHome(): Response
    {
        return $this->render('home/index.html.twig');// Cette fonction envoie vers la page home/index.html.twig
                                                    // cette page est la page d'accueil de l'app ProductiveX
    }

    // #[Route('/login', name: 'app_blog_login')]
    // public function login(): Response
    // {
    //     return $this->render('home/login.html.twig');// Cette fonction envoie vers la page home/login.html.twig
    //                                                 // cette page est la page de login de l'app
    // }

    #[Route('/verifi-email', name: 'app_blog_verifiEmail')]
    public function verifiEmail(): Response
    {
        return $this->render('home/verifiEmail.html.twig');// Cette fonction envoie vers la page home/verifiEmail.html.twig
                                                        // cette page est la page qui demande juste l'email de l'employeur (compte entreprise)
    }

    // #[Route('/confirm-email', name: 'app_blog_confirmEmail')]
    // public function confirmEmail(): Response
    // {
    //     return $this->render('home/confirmEmail.html.twig');// Cette fonction envoie vers la page home/confirmEmail.html.twig
    //                                                         // cette page est la page qui envoie un email à l'employeur (compte entreprise) pour vérifie son email
    // }

    #[Route('/registre-entreprise', name: 'app_blog_formEntreprise')]
    public function formEntreprise(): Response
    {
        return $this->render('home/formEntreprise.html.twig');// Cette fonction envoie vers la page home/formEntreprise.html.twig
                                                            // cette page est la page qui pour inscrire un compte entreprise
    }

    
}