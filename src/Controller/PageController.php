<?php

declare(strict_types=1);

namespace App\Controller;

use App\Mercure\TopicsHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PageController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    #[Route('/admin/{path}', requirements: ['path' => '.+'])]
    public function admin(Request $request, TopicsHelper $topicsHelper): Response
    {
        $baseUrl = $this->generateUrl('home', [], UrlGeneratorInterface::ABSOLUTE_URL);

        return $this->render('admin.html.twig', [
            'config' => [
                'host' => $request->getHost(),
                'baseUrl' => $baseUrl,
            ],
            'mercureTopics' => $topicsHelper->getMercureTopics(),
        ]);
    }

    #[Route('/', name: 'home')]
    public function adminRedirect(): Response
    {
        return $this->redirectToRoute('admin');
    }
}
