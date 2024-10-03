<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Entity\LinkedInMessage;
use App\Repository\JobOfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LinkedInMessageController extends AbstractController
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    #[Route('/linkedin-message/generate', name: 'linkedin_message_generate', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function generate(Request $request, JobOfferRepository $jobOfferRepository, EntityManagerInterface $em): JsonResponse
    {
        $this->logger->info('Generating LinkedIn message...');
        
        $data = json_decode($request->getContent(), true);
        $jobOfferId = $data['jobOfferId'] ?? null;

        if (!$jobOfferId) {
            return new JsonResponse(['error' => 'Job offer ID is required'], JsonResponse::HTTP_BAD_REQUEST);
        }

        /** @var JobOffer $jobOffer */
        $jobOffer = $jobOfferRepository->find($jobOfferId);
        
        if (!$jobOffer) {
            return new JsonResponse(['error' => 'Job offer not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Générer le message en utilisant les informations de l'offre d'emploi
        $content = sprintf(
            "Bonjour %s, je suis très intéressé par le poste de %s chez %s. J'ai les compétences requises pour ce rôle et je serais ravi d'échanger davantage.",
            $jobOffer->getContactPerson(),
            $jobOffer->getTitle(),
            $jobOffer->getCompany()
        );

        $linkedInMessage = new LinkedInMessage();
        $linkedInMessage->setContent($content);
        $linkedInMessage->setJobOffer($jobOffer);
        $linkedInMessage->setAppUser($this->getUser());
        $linkedInMessage->setCreatedAt(new \DateTimeImmutable());
        $linkedInMessage->setUpdatedAt(new \DateTimeImmutable());

        $em->persist($linkedInMessage);
        $em->flush();

        return new JsonResponse(['success' => 'Message generated successfully', 'message' => $content], JsonResponse::HTTP_OK);
    }

    #[Route('/linkedin-message/{id}', name: 'linkedin_message_show', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $linkedInMessage = $em->getRepository(LinkedInMessage::class)->find($id);

        if (!$linkedInMessage) {
            throw $this->createNotFoundException('Message not found');
        }

        return $this->render('linkedin_message/show.html.twig', [
            'message' => $linkedInMessage,
        ]);
    }
}