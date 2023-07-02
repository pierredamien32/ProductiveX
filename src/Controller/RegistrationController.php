<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $entreprise = new Entreprise();
        $entreprise->setUserid($user);
        $roles = ['ROLE_USER', 'ROLE_ENT'];
        $user->setRoles($roles);
        $user->setRoles(['ROLE_USER', 'ROLE_ENT']);
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
            if ($existingUser) {
                // L'utilisateur existe déjà, afficher un message demandant de se connecter
                $this->addFlash('error', 'Cet e-mail existe déjà. Veuillez vous connecter plutôt que de vous inscrire.');
                return $this->redirectToRoute('app_login');
            }
            $logo = $form->get('logo')->getData();
            if ($logo) {
                // Générez un nom de fichier unique
                $logoName = md5(uniqid()) . '.' . $logo->guessExtension();

                $logo->move(
                    $this->getParameter('logo_directory'),
                    $logoName
                );
                $entreprise->setLogo($logoName);
            }
            // dd($entreprise);
            $entityManager->persist($entreprise);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address('teamproductivex@gmail.com', 'ProductiveX Team\'s'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email  
            return $this->render('home/confirmEmail.html.twig', ['user' => $user]);
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Cette fonction envoie vers la page home/confirmEmail.html.
     * cette page est la page qui envoie un email à l'employeur (compte entreprise) pour vérifie son email
     *
     * @return Response
     */
    #[Route('/confirm-email', name: 'app_blog_confirmEmail')]
    public function confirmEmail(): Response
    {
        return $this->render('home/confirmEmail.html.twig');
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->render('home/confirmEmail.html.twig', ['user' => $user]);
            // return $this->redirectToRoute('app_blog_confirmEmail', ['user' => $user]);
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre adresse e-mail a été vérifiée.');

        return $this->redirectToRoute('app_entreprise');
    }


    /**
     * Renvoi de l'email de verification
     */
    #[Route('/verify/email/resend/{id}', name: 'app_resend_verification_email', methods: ['GET', 'POST'])]
    public function resendVerificationEmail(EntityManagerInterface $manager, $id): Response
    {
        // Récupérer l'utilisateur depuis la requête
        $user = $manager->getRepository(User::class)->find($id);

        // generate a signed url and email it to the user
        $this->emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $user,
            (new TemplatedEmail())
                ->from(new Address('teamproductivex@gmail.com', 'ProductiveX Team\'s'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );

        $this->addFlash('success', "L'e-mail de vérification a été renvoyé. Allez verifier votre boite email");
        return $this->render('home/confirmEmail.html.twig', ['user' => $user]);
    }
}