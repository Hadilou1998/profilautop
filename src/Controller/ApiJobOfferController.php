<?php

namespace App\Controller;

use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ApiJobOfferController extends AbstractController
{
    #[Route('/api/job-offers/update-status', name: 'api_job_offer_update_status', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function updateStatus(Request $request, JobOfferRepository $jobOfferRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $jobOfferId = $data['jobOfferId'] ?? null;
        $newStatus = $data['status'] ?? null;

        if (!$jobOfferId || !$newStatus) {
            return new JsonResponse(['error' => 'Invalid data provided'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $jobOffer = $jobOfferRepository->find($jobOfferId);

        if (!$jobOffer) {
            return new JsonResponse(['error' => 'Job offer not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $jobOffer->setStatus($newStatus);
        $jobOfferRepository->save($jobOffer, true);

        return new JsonResponse(['success' => 'Status updated successfully'], JsonResponse::HTTP_OK);
    }
}