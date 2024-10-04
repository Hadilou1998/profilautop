<?php

namespace App\Controller;

use App\Entity\CoverLetter;
use App\Entity\JobOffer;
use App\Repository\CoverLetterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/cover-letter")]
class CoverLetterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/cover-letter/generate', name: 'cover_letter_generate', methods: ['POST'])]
    public function generate(Request $request): Response
    {
        // Génération de la lettre de motivation personnalisée
        $jobOfferId = $request->request->get('jobOfferId');
        $content = $request->request->get('content');

        $jobOffer = $this->entityManager->getRepository(JobOffer::class)->find($jobOfferId);
        if (!$jobOffer) {
            return $this->json(['error' => 'Job offer not found.'], Response::HTTP_NOT_FOUND);
        }

        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'User not authenticated.'], Response::HTTP_UNAUTHORIZED);
        }

        $coverLetter = new CoverLetter();
        $coverLetter->setContent($content);
        $coverLetter->setCreatedAt(new \DateTimeImmutable());
        $coverLetter->setUpdatedAt(new \DateTimeImmutable());
        $coverLetter->setJobOffer($jobOffer);
        $coverLetter->setAppUser($this->getUser());

        $this->entityManager->persist($coverLetter);
        $this->entityManager->flush();

        return $this->json(['message' => 'Cover letter generated successfully.', 'coverLetterId' => $coverLetter->getId()], Response::HTTP_CREATED);
    }

    #[Route('/cover-letter/{id}', name: 'cover_letter_show', methods: ['GET'])]
    public function show(int $id, CoverLetterRepository $coverLetterRepository): Response
    {
        $coverLetter = $coverLetterRepository->find($id);
        if (!$coverLetter) {
            throw $this->createNotFoundException('Cover letter not found.');
        }

        if ($coverLetter->getAppUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You do not have access to this cover letter.');
        }

        return $this->render('cover_letter/show.html.twig', [
            'coverLetter' => $coverLetter,
        ]);
    }
}