<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UsersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Users::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID'),
            TextField::new('nom', 'Nom'),
            EmailField::new('email', 'Email'),
            // Utilisation de TextField avec un type Password pour le champ "mot_de_passe"
            TextField::new('password', 'Mot de passe')
                ->setFormType(PasswordType::class)
                ->setFormTypeOption('always_empty', true)
                ->setRequired(false),  // Ne pas rendre obligatoire lors de l'édition pour éviter la réécriture si non modifié
                BooleanField::new('isVerified', 'Vérifié')->setFormTypeOption('mapped', false),
                ArrayField::new('roles', 'Rôles'),
        ];
    }
}
