<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/dashboard/users', name: 'app_users')]
    public function index(
        UserService $service,
    ): Response {
        $users = $service->getAllUsers();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/dashboard/users/{id}/edit', name: 'app_user_edit')]
    public function edit(
        User $user,
        Request $request,
        UserService $service,
    ): Response {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->updateUser($user);

            $this->addFlash(
                'success',
                'Le profil a été modifié avec succès.'
            );

            return $this->redirectToRoute('app_users');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }

    #[Route('/dashboard/users/{id}/delete', name: 'app_user_delete', methods: ['POST'])]
    public function delete(
        User $user,
        Request $request,
        UserService $service,
    ): Response {
        if (!$this->isCsrfTokenValid(
            'delete_user_' . $user->getId(),
            $request->request->get('_token')
        )) {
            throw $this->createAccessDeniedException(
                'Le token CSRF est invalide.'
            );
        }

        $service->deleteUser($user);

        $this->addFlash(
            'success',
            'Le profil a été supprimé avec succès.'
        );

        return $this->redirectToRoute('app_users');
    }
}
