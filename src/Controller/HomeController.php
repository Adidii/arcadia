<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\OpeningAndClosingHours;
use App\Entity\Habitat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupération des services
        $services = $entityManager->getRepository(Service::class)->findAll();

        // Récupération des horaires
        $horaires = $entityManager->getRepository(OpeningAndClosingHours::class)->findAll();

        // Récupération des habitats
        $habitats = $entityManager->getRepository(Habitat::class)->findAll();

        // Chemins des images pour le slider
        $sliderImages = [
            'images/image1.jpeg',
            'images/image2.jpeg',
            'images/image3.jpeg',
        ];

        return $this->render('home/index.html.twig', [
            'services' => $services,
            'horaires' => $horaires,
            'habitats' => $habitats,
            'sliderImages' => $sliderImages,
        ]);
    }

    #[Route('/contact', name: 'contact', methods: ['POST'])]
    public function contact(Request $request): Response
    {
        // Récupération des données du formulaire
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $subject = $request->request->get('subject');
        $message = $request->request->get('message');

        // Logique pour traiter le formulaire de contact
        $this->addFlash('success', 'Votre message a été envoyé avec succès.');

        return $this->redirectToRoute('home');
    }
}
