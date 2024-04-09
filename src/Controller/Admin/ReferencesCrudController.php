<?php

namespace App\Controller\Admin;

use App\Entity\References;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReferencesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return References::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name', 'Référence'),
            AssociationField::new('produits')->autocomplete(),
        ];
    }

}
