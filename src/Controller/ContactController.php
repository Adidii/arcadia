<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contact;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(): Response
    {
        return $this->render('contact/contact.html.twig');
    }

    #[Route('/contact/submit', name: 'contact_submit', methods: ['POST'])]
    public function submit(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer les données du formulaire
        $name = $request->get('name');
        $email = $request->get('email');
        $subject = $request->get('subject'); // Vous pouvez stocker le sujet si nécessaire dans l'entité
        $message = $request->get('message');

        // Créer une nouvelle instance de Contact et définir les valeurs
        $contact = new Contact();
        $contact->setNom($name);
        $contact->setEmail($email);
        $contact->setMessage($message);
        $contact->setDate(new \DateTime()); // Enregistrer la date actuelle

        // Persister et enregistrer l'entité dans la base de données
        $entityManager->persist($contact);
        $entityManager->flush();

        // Message de succès
        $this->addFlash('success', 'Votre message a été envoyé avec succès !');

        return $this->redirectToRoute('contact');
    }
}
