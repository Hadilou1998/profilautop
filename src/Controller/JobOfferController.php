<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Repository\JobOfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JobOfferController extends AbstractController
{
    private $em;
    private $jobOfferRepository;

    public function __construct(EntityManagerInterface $em, JobOfferRepository $jobOfferRepository)
    {
        $this->em = $em;
        $this->jobOfferRepository = $jobOfferRepository;   
    }

    #[Route('/job-offers', name: 'app_offers', methods: ['GET'])]
    public function list(): Response
    {
        $jobOffers = $this->jobOfferRepository->findAll();

        return $this->render('job_offer/list.html.twig', [
            'jobOffers' => $jobOffers,
        ]);
    }

    #[Route('/job-offers/new', name: 'app_offer_new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        // Create new job offer logic here
        $jobOffer = new JobOffer();

        // Save the job offer to the database
        $this->em->persist($jobOffer);
        $this->em->flush();

        return $this->render('job_offer/new.html.twig', [
            'jobOffer' => $jobOffer,
        ]);
    }

    #[Route('/job-offers/{id}', name: 'app_offer_show', methods: ['GET'])]
    public function show($id): Response
    {
        // Retrieve job offer by ID
        $jobOffer = $this->jobOfferRepository->find($id);

        if (!$jobOffer) {
            throw $this->createNotFoundException('Job offer not found');
        }

        return $this->render('job_offer/show.html.twig', [
            'jobOffer' => $jobOffer,
        ]);
    }

    #[Route('/job-offers/{id}/edit', name: 'app_offer_edit', methods: ['GET', 'POST'])]
    public function edit($id): Response
    {
        // Edit job offer logic here
        return $this->redirectToRoute('app_offers');

        return $this->render('job_offer/edit.html.twig', [
            'jobOffer' => $jobOffer,
        ]);
    }

    #[Route('/job-offers/{id}/delete', name: 'app_offer_delete', methods: ['POST'])]
    public function delete($id): Response
    {
        // Delete job offer logic here
        return $this->redirectToRoute('app_offers');
    }
}