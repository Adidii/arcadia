<?php
namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminServiceController extends AbstractController
{
    #[Route('/admin/service/new', name: 'admin_service_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($service);
            $entityManager->flush();

            $this->addFlash('success', 'Le service a été ajouté avec succès.');

            return $this->redirectToRoute('services'); // Redirige vers la liste des services
        }

        return $this->render('admin/service/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
