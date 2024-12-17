<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Entity\User;
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

class LoginController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailerInterface)
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

    #[Route(path: '/forgot', name: 'forgot', methods: ['GET'])]
    public function forgotForm(): Response
    {
        return $this->render('auth/forgot.html.twig');
    }

    #[Route(path: '/forgot', name: 'forgot_post', methods: ['POST'])]
    public function forgot(Request $request, UserRepository $userRepository, MailerInterface $mailer): Response
    {
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
                ->text('email/reset.html.twig')
                ->context([
                    'resetToken' => $resetToken,
                    'email' => $user->getEmail(),
                    'resetUrl' => $this->generateUrl('reset', [
                        'token' => $resetToken,
                    ], UrlGeneratorInterface::ABSOLUTE_URL),
                ]);

            $this->mailerInterface->send($email);

                $this->addFlash('success', 'Un email pour réinitialiser votre mot de passe a été envoyé.');

            }
        }
        return $this->render('auth/forgot.html.twig');
    }

    #[Route(path: '/confirm', name: 'confirm')]
    public function confirm(): Response
    {
        return $this->render('auth/confirm.html.twig');
    }

    #[Route(path: '/reset', name: 'reset')]
    public function reset(): Response
    {
        return $this->render('auth/reset.html.twig');
    }
}
