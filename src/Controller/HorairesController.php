<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\OpeningAndClosingHours;
use Doctrine\ORM\EntityManagerInterface;

class HorairesController extends AbstractController
{
    #[Route('/horaires', name: 'horaires')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupère les horaires depuis la base de données
        $horaires = $entityManager->getRepository(OpeningAndClosingHours::class)->findAll();

        // Passe les horaires au template Twig
        return $this->render('horaires/horaires.html.twig', [
            'horaires' => $horaires,
        ]);
    }
}
