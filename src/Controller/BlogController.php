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
        return $this->render('home/index.html.twig');
    }

    #[Route('/login', name: 'app_blog_login')]
    public function login(): Response
    {
        return $this->render('home/login.html.twig');
    }

    #[Route('/verifi-email', name: 'app_blog_verifiEmail')]
    public function verifiEmail(): Response
    {
        return $this->render('home/verifiEmail.html.twig');
    }

    #[Route('/confirm-email', name: 'app_blog_confirmEmail')]
    public function confirmEmail(): Response
    {
        return $this->render('home/confirmEmail.html.twig');
    }

    #[Route('/registre-entreprise', name: 'app_blog_formEntreprise')]
    public function formEntreprise(): Response
    {
        return $this->render('home/formEntreprise.html.twig');
    }
}
