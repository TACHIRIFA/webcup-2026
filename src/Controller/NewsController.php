<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use App\Service\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsController extends AbstractController
{
    #[Route('/dashboard/news', name: 'app_news')]
    public function index(
        NewsService $service,
    ): Response {
        $news = $service->getAllNews();

        return $this->render('news/index.html.twig', [
            'news' => $news,
        ]);
    }

    #[Route('/dashboard/news/new', name: 'app_news_new')]
    public function new(
        Request $request,
        NewsService $service,
    ): Response {
        $news = new News();

        $news->setPublishAt(new \DateTime());

        $form = $this->createForm(
            NewsType::class,
            $news,
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $service->createNews($news);

            $this->addFlash(
                'success',
                'L’actualité a été créée avec succès.'
            );

            return $this->redirectToRoute('app_news');
        }

        return $this->render('news/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/dashboard/news/{id}/edit', name: 'app_news_edit')]
    public function edit(
        News $news,
        Request $request,
        NewsService $service,
    ): Response {
        $form = $this->createForm(
            NewsType::class,
            $news,
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $service->updateNews($news);

            $this->addFlash(
                'success',
                'L’actualité a été modifiée avec succès.'
            );

            return $this->redirectToRoute('app_news');
        }

        return $this->render('news/edit.html.twig', [
            'form' => $form,
            'news' => $news,
        ]);
    }

    #[Route(
        '/dashboard/news/{id}/delete',
        name: 'app_news_delete',
        methods: ['POST']
    )]
    public function delete(
        News $news,
        Request $request,
        NewsService $service,
    ): Response {
        if (!$this->isCsrfTokenValid(
            'delete_news_' . $news->getId(),
            $request->request->get('_token')
        )) {
            throw $this->createAccessDeniedException(
                'Le token CSRF est invalide.'
            );
        }

        $service->deleteNews($news);

        $this->addFlash(
            'success',
            'L’actualité a été supprimée avec succès.'
        );

        return $this->redirectToRoute('app_news');
    }
}
