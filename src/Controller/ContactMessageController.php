<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Form\ContactMessageType;
use App\Service\ContactMessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactMessageController extends AbstractController
{
    #[Route('/dashboard/contact', name: 'app_contact')]
    public function index(
        Request $request,
        ContactMessageService $service,
    ): Response {
        $contactMessage = new ContactMessage();

        $form = $this->createForm(
            ContactMessageType::class,
            $contactMessage,
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->createMessage($contactMessage);

            $this->addFlash(
                'success',
                'Votre message a été envoyé avec succès.'
            );

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
