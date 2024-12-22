<?php

namespace App\Controller\Admin;

use App\Entity\Consumption;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class ConsumptionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Consumption::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('animal', 'Animal associé'),
            TextField::new('nourriture', 'Type de Nourriture'),
            NumberField::new('grammage', 'Grammage'),
            DateField::new('date', 'Date'),
        ];
    }
}
