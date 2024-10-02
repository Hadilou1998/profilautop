<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LinkedinMessageController extends AbstractController
{
    #[Route('/linkedin/message', name: 'app_linkedin_message')]
    public function index(): Response
    {
        return $this->render('linkedin_message/index.html.twig', [
            'controller_name' => 'LinkedinMessageController',
        ]);
    }
}
