<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @Route("/admin/{path}", requirements={"path"=".+"})
     */
    public function admin(Request $request)
    {
        return $this->render('admin.html.twig', [
            'config' => [
                'host' => $request->getHost(),
                'sseHost' => 'http://127.0.0.1:8008/.well-known/mercure', // TODO
            ],
        ]);
    }

    /**
     * @Route("/")
     */
    public function adminRedirect()
    {
        return $this->redirectToRoute('admin');
    }
}
