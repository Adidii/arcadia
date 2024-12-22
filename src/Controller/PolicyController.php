<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PolicyController extends AbstractController
{
    #[Route('/terms', name: 'terms')]  // Renomme ici en 'terms' pour correspondre à ton usage dans Twig
    public function showTerms(): Response
    {
        return $this->render('policy/terms.html.twig');
    }

    #[Route('/privacy', name: 'privacy')]  // Renomme également la route pour 'privacy'
    public function showPrivacy(): Response
    {
        return $this->render('policy/privacy.html.twig');
    }
}
