<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JobOfferController extends AbstractController
{
    #[Route('/job-offers', name: 'app_offers', methods: ['GET'])]
    public function list(): Response
    {
        return $this->render('job_offer/list.html.twig', [
            'controller_name' => 'JobOfferController',
        ]);
    }

    #[Route('/job-offers/new', name: 'app_offer_new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        return $this->render('job_offer/new.html.twig', [
            'controller_name' => 'JobOfferController',
        ]);
    }

    #[Route('/job-offers/{id}', name: 'app_offer_show', methods: ['GET'])]
    public function show($id): Response
    {
        return $this->render('job_offer/show.html.twig', [
            'controller_name' => 'JobOfferController',
            'id' => $id,
        ]);
    }

    #[Route('/job-offers/{id}/edit', name: 'app_offer_edit', methods: ['GET', 'POST'])]
    public function edit($id): Response
    {
        return $this->render('job_offer/edit.html.twig', [
            'controller_name' => 'JobOfferController',
            'id' => $id,
        ]);
    }

    #[Route('/job-offers/{id}/delete', name: 'app_offer_delete', methods: ['POST'])]
    public function delete($id): Response
    {
        // Delete job offer logic here
        return $this->redirectToRoute('app_offers');
    }
}