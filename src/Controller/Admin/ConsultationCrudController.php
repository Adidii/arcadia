<?php

namespace App\Controller\Admin;

use App\Entity\Consultation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ConsultationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Consultation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('veterinarian', 'Vétérinaire'), // Matches the property in the entity
            TextareaField::new('etatSante', 'État de santé'), // CamelCase matches the entity
            DateField::new('datePassage', 'Date de passage'), // CamelCase matches the entity
        ];
    }
}
