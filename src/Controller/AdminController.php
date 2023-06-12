<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/home/admin', name: 'app_admin')]
    public function homeAdmin(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/home/add-admin', name: 'app_form_admin')]
    public function formAdmin(): Response
    {
        return $this->render('admin/addAdmin.html.twig');
    }
    
}
