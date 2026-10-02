<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        $modules = [
            [
                'name' => 'Module 1',
                'route' => 'app_dashboard',
            ],
            [
                'name' => 'Module 2',
                'route' => 'app_dashboard',
            ],
            [
                'name' => 'Module 3',
                'route' => 'app_dashboard',
            ],
        ];

        return $this->render('dashboard/index.html.twig', [
            'modules' => $modules,
        ]);
    }
}
