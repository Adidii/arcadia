<?php

namespace App\Controller;

use App\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ServicesController extends AbstractController
{
    #[Route('/services', name: 'services')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les services depuis la base de données
        $services = $entityManager->getRepository(Service::class)->findAll();

        return $this->render('services/services.html.twig', [
            'services' => $services,
        ]);
    }
}
