<?php

namespace App\Controller\Admin;

use App\Entity\Generique;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GeneriqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Generique::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            TextField::new('anime'),
            AssociationField::new('Album')
        ];
    }
}
