<?php

namespace App\Controller\Admin;

use App\Entity\AnimalImage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class AnimalImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AnimalImage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id_image', 'ID')->hideOnForm();
        yield TextField::new('url', 'URL');
        yield TextField::new('description', 'Description');
        yield AssociationField::new('animal', 'Animal associé');
    }
}
