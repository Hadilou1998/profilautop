<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LinkedinMessageController extends AbstractController
{
    #[Route('/linkedin-message/generate', name: 'app_linkedin_message_generate')]
    public function generate(): Response
    {
        // aucun chemin spécifié pour cette route
        return $this->render('N/A', [
            'controller_name' => 'LinkedinMessageController',
        ]);
    }

    #[Route('/linkedin-message/{id}', name: 'app_linkedin_message_show', methods: ['GET'])]
    public function show($id): Response
    {
        return $this->render('linkedin_message/show.html.twig', [
            'controller_name' => 'LinkedinMessageController',
            'id' => $id,
        ]);
    }
}