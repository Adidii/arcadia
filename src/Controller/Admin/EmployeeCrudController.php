<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class EmployeeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Employee::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id_employe')->hideOnForm(),
            TextField::new('nom', 'Nom'),
            TextField::new('email', 'Email'),
            TextField::new('mot_de_passe', 'Mot de Passe')->onlyOnForms(),
            ChoiceField::new('role', 'Rôle')
                ->setChoices([
                    'Employé' => 'employe',
                    'Vétérinaire' => 'veterinaire',
                ]),
        ];
    }
}
