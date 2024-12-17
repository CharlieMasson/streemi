<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LoginController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
    }

    #[Route(path: '/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('auth/register.html.twig');
    }

    #[Route(path: '/forgot', name: 'forgot')]
    public function forgot(Request $request, UserRepository $userRepository, MailerInterface $mailer, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->get('email');
            if ($email === null) {
                $this->addFlash('error', 'Adresse email non fournie.');
            } else {
                $user = $userRepository->findOneBy(array('email' => $email));
        
                if ($user === null) {
                    $this->addFlash('error', 'Cet email ne correspond à aucun compte.');

                } else {
                    $resetToken = Uuid::v4()->toRfc4122(); // Génère un UUID unique
                    $user->setResetToken($resetToken);

                    $this->entityManager->persist($user);
                    $this->entityManager->flush();

                    $email = (new Email())
                    ->from('noreply@example.com')
                    ->to($user->getEmail())
                    ->subject('Réinitialisation de votre mot de passe')
                    ->html('<html>
                        <head>
                            <meta charset="UTF-8">
                            <title>Réinitialisation de votre mot de passe</title>
                        </head>
                        <body>
                            <h1>Réinitialisation de votre mot de passe</h1>
                            <p>Bonjour,</p>
                            <p>Vous avez demandé à réinitialiser votre mot de passe. Cliquez sur le lien ci-dessous pour procéder :</p>
                            <p>
                                <a href="' . $this->generateUrl('reset', ['token' => $resetToken, 'email' => $email], UrlGeneratorInterface::ABSOLUTE_URL) . '">Réinitialiser mon mot de passe</a>
                            </p>
                            <p>Si vous n\'avez pas demandé cette réinitialisation, vous pouvez ignorer cet email.</p>
                            <p>Cordialement,</p>
                            <p>L\'équipe Streemi</p>
                        </body>
                    </html>');

                    $mailer->send($email);
                    $this->addFlash('success', 'Un email pour réinitialiser votre mot de passe a été envoyé.');
                }
            }
        }
        return $this->render('auth/forgot.html.twig');
    }

    #[Route(path: '/confirm', name: 'confirm')]
    public function confirm(): Response
    {
        return $this->render('auth/confirm.html.twig');
    }

    #[Route(path: '/reset/{token}', name: 'reset')]
    public function reset(string $token, UserRepository $userRepository, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $userRepository->findOneBy(['resetToken' => $token]);

        if ($user === null) {
            $this->addFlash('error', 'Token de réinitialisation invalide ou expiré.');
            return $this->redirectToRoute('login');
        }

        if ($request->isMethod('POST')) {
            $password = $request->request->get('password');
            $passwordRepeat = $request->request->get('password_repeat');

            if ($password !== $passwordRepeat) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
            } elseif (strlen($password) < 8) {
                $this->addFlash('error', 'Le mot de passe doit contenir au moins 8 caractères.');
            } else {
                $hashedPassword = $passwordHasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);
                $user->setResetToken(null);
    
                $this->entityManager->persist($user);
                $this->entityManager->flush();
    
                $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès.');
                return $this->redirectToRoute('login');
            }
        }

        return $this->render('auth/reset.html.twig', [
            'email' => $user->getEmail(),
        ]);
    }
}

