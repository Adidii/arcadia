<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HabitatRepository; // Importez le repository Habitat

class HabitatController extends AbstractController
{
    #[Route('/habitats', name: 'habitat_list')]
    public function index(HabitatRepository $habitatRepository): Response
    {
        // Récupérer les habitats depuis la base de données
        $habitats = $habitatRepository->findAll();

        return $this->render('habitat/habitats.html.twig', [
            'habitats' => $habitats,
        ]);
    }
}
