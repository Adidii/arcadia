<?php

namespace App\Controller\Admin;

use App\Entity\Administrator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;

class AdministratorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Administrator::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Administrateurs')
            ->setEntityLabelInSingular('Administrateur')
            ->setPageTitle('index', 'Gestion des Administrateurs');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id_admin')->hideOnForm(),
            TextField::new('nom', 'Nom'),
            EmailField::new('email', 'Email'),
            TextField::new('mot_de_passe', 'Mot de passe')->hideOnIndex(),
        ];
    }
}
