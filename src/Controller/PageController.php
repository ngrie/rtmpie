<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PageController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @Route("/admin/{path}", requirements={"path"=".+"})
     */
    public function admin(Request $request)
    {
        $baseUrl = $this->generateUrl('home', [], UrlGeneratorInterface::ABSOLUTE_URL);

        return $this->render('admin.html.twig', [
            'config' => [
                'host' => $request->getHost(),
                'baseUrl' => $baseUrl,
                'sseHost' => $baseUrl . '.well-known/mercure',
            ],
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function adminRedirect()
    {
        return $this->redirectToRoute('admin');
    }
}
