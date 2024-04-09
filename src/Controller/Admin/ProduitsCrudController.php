<?php

namespace App\Controller\Admin;

use App\Entity\Produits;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProduitsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produits::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('reference_fk', 'Référence')->autocomplete(),
            AssociationField::new('categorie_fk', 'Catégorie')->autocomplete(),
            AssociationField::new('distributeur_fk', 'Distributeur')->autocomplete(),
            AssociationField::new('user_fk', 'Utilisateur')->autocomplete(),
            TextField::new('name', 'Nom du produit'),
            DateTimeField::new('createdAt', 'Créé le')->onlyOnIndex(),
            DateTimeField::new('updatedAt', 'MAJ le')->onlyOnIndex(),
        ];
    }

}
