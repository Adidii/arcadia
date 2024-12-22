<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use App\Entity\Users;
use App\Entity\Administrator;
use App\Entity\Service;
use App\Entity\OpeningAndClosingHours;
use App\Entity\Contact; // Ajout de l'entité Contact
use App\Entity\Habitat;
use App\Entity\Employee;
use App\Entity\Veterinarian; // Ajoute cette ligne en haut
use App\Entity\Consultation; // Ajoute cette ligne en haut
use App\Entity\Animal; // Ajoute cette ligne en haut
use App\Entity\AnimalImage; 
use App\Entity\Consumption;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class AdminDashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UsersCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin Dashboard');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', Users::class);
        yield MenuItem::linkToCrud('Services', 'fas fa-cogs', Service::class);
        yield MenuItem::linkToCrud('Horaires d\'ouverture', 'fas fa-clock', OpeningAndClosingHours::class);
        yield MenuItem::linkToCrud('Contact', 'fas fa-envelope', Contact::class);
        yield MenuItem::linkToCrud('Habitat', 'fas fa-tree', Habitat::class);
        yield MenuItem::linkToCrud('Employés', 'fas fa-user-tie', Employee::class);
        yield MenuItem::linkToCrud('Vétérinaires', 'fas fa-user-md', Veterinarian::class); // Ajoute cette ligne dans `configureMenuItems()`
        yield MenuItem::linkToCrud('Consultations', 'fas fa-notes-medical', Consultation::class); // Ajoute cette ligne dans `configureMenuItems()`
        yield MenuItem::linkToCrud('Administrateurs', 'fas fa-user-shield', Administrator::class);
        yield MenuItem::linkToCrud('Animaux', 'fas fa-paw', Animal::class);
        yield MenuItem::linkToCrud('Animal Images', 'fas fa-image', AnimalImage::class);
        yield MenuItem::linkToCrud('Consumptions', 'fas fa-utensils', Consumption::class);


    }
    
}
