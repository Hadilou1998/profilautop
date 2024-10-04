<?php

namespace App\Controller;

use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class KanbanController extends AbstractController
{
    #[Route('/kanban', name: 'app_kanban', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(JobOfferRepository $jobOfferRepository): Response
    {
        $user = $this->getUser();
        $jobOffers = $jobOfferRepository->findBy(['app_user' => $user]);

        $groupedJobOffers = [
            'a_postuler' => [],
            'en_attente' => [],
            'entretien' => [],
            'refuse' => [],
            'accepte' => [],
        ];

        foreach ($jobOffers as $jobOffer) {
            $status = strtolower(str_replace(' ', '_', $jobOffer->getStatus()));
            $groupedJobOffers[$status][] = $jobOffer;
        }

        return $this->render('kanban/index.html.twig', [
            'jobOffers' => $groupedJobOffers,
        ]);
    }
}
