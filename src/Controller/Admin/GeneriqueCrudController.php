<?php

namespace App\Controller\Admin;

use App\Entity\Generique;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class GeneriqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Generique::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('anime'),
            TextField::new('type'),
            IntegerField::new('numero'),
            TextField::new('titre'),
            TextField::new('artiste'),
        ];
    }
}
