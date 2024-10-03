<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoverLetterController extends AbstractController
{
    #[Route('/cover-letter/generate', name: 'app_cover_letter_generate')]
    public function generate()
    {
        // aucun chemin spécifié pour cette route
        return $this->render('N/A', [
            'controller_name' => 'CoverLetterController',
        ]);
    }

    #[Route('/cover-letter/{id}', name: 'app_cover_letter_show', methods: ['GET'])]
    public function show($id)
    {
        return $this->render('cover_letter/show.html.twig', [
            'controller_name' => 'CoverLetterController',
            'id' => $id,
        ]);
    }
}
