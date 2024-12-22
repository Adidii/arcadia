<?php
namespace App\Controller\Admin;
use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController; // Import correct
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->setFormTypeOption('mapped', false), // Ne pas mapper le champ id dans le formulaire
            TextField::new('nom', 'Nom'),
            TextField::new('description', 'Description'),
            TimeField::new('horaire_ouverture', 'Horaire d\'ouverture'),
            TimeField::new('horaire_fermeture', 'Horaire de fermeture'),
        ];
    }
}
