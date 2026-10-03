<?php

namespace App\Controller;

use App\Entity\MunicipalService;
use App\Form\MunicipalServiceType;
use App\Service\MunicipalServiceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MunicipalServiceController extends AbstractController
{
    #[Route('/dashboard/services', name: 'app_services')]
    public function index(
        MunicipalServiceService $service,
    ): Response {
        $services = $service->getAllServices();

        return $this->render('municipal_service/index.html.twig', [
            'services' => $services,
        ]);
    }

    #[Route('/dashboard/services/new', name: 'app_services_new')]
    public function new(
        Request $request,
        MunicipalServiceService $service,
    ): Response {
        $municipalService = new MunicipalService();

        $form = $this->createForm(
            MunicipalServiceType::class,
            $municipalService,
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->createService($municipalService);

            return $this->redirectToRoute('app_services');
        }

        return $this->render('municipal_service/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/dashboard/services/{id}/edit', name: 'app_services_edit')]
    public function edit(
        MunicipalService $municipalService,
        Request $request,
        MunicipalServiceService $service,
    ): Response {
        $form = $this->createForm(
            MunicipalServiceType::class,
            $municipalService,
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->updateService($municipalService);

            return $this->redirectToRoute('app_services');
        }

        return $this->render('municipal_service/edit.html.twig', [
            'form' => $form,
            'municipalService' => $municipalService,
        ]);
    }
    #[Route(
        '/dashboard/services/{id}/delete',
        name: 'app_services_delete',
        methods: ['POST']
    )]
    public function delete(
        MunicipalService $municipalService,
        Request $request,
        MunicipalServiceService $service,
    ): Response {
        if (!$this->isCsrfTokenValid(
            'delete_service_' . $municipalService->getId(),
            $request->request->get('_token')
        )) {
            throw $this->createAccessDeniedException(
                'Le token CSRF est invalide.'
            );
        }

        $service->deleteService($municipalService);

        return $this->redirectToRoute('app_services');
    }
}
