<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_dashboard');
        }

        $error = null;

        if ($request->isMethod('POST')) {
            $email = trim((string) $request->request->get('email'));
            $password = (string) $request->request->get('password');
            $passwordConfirmation = (string) $request->request->get('password_confirmation');

            if (!$this->isCsrfTokenValid('register', (string) $request->request->get('_token'))) {
                $error = 'La session a expiré. Veuillez réessayer.';
            } elseif (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Veuillez saisir une adresse e-mail valide.';
            } elseif (!$password) {
                $error = 'Veuillez saisir un mot de passe.';
            } elseif (strlen($password) < 6) {
                $error = 'Le mot de passe doit contenir au moins 6 caractères.';
            } elseif ($password !== $passwordConfirmation) {
                $error = 'Les mots de passe ne correspondent pas.';
            } elseif ($entityManager->getRepository(User::class)->findOneBy(['email' => $email])) {
                $error = 'Un compte existe déjà avec cette adresse e-mail.';
            }

            if (!$error) {
                $user = new User();

                $user->setEmail($email);
                $user->setRoles(['ROLE_USER']);
                $user->setPassword(
                    $passwordHasher->hashPassword($user, $password)
                );

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('registration/register.html.twig', [
            'error' => $error,
        ]);
    }
}
