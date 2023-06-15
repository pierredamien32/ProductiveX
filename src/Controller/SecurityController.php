<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\SecurityBundle\Security;

class SecurityController extends AbstractController
{
    public function __construct(Security $security) {
    }

    
     #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();

        if ($user) {
            
            return $this->redirectToRoute('app_dashboard');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Récupérer l'utilisateur connecté
        // $user = $this->getUser();

        // if ($this->isGranted('ROLE_ADMIN')) {
            
        //     // Redirection vers la page d'administration de l'admin
        //     return $this->redirectToRoute('adinm');
            
        // }elseif ($this->isGranted('ROLE_ENT')) {
            
        //     // Redirection vers la page d'administration de l'entreprise
        //     return $this->redirectToRoute('app_dashboard');
            
        // } elseif ($this->isGranted('ROLE_EMP')) {
            
        //     // Redirection vers la page utilisateur
        //     return $this->redirectToRoute('emp_dashboard');
            
        // } 
        // Redirection vers le tableau de bord
        
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): never
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
   
}