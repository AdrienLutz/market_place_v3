<?php

namespace App\Controller\Admin;

use App\Entity\Produits;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
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
            TextField::new('name', 'Nom du produit'),
            // TODO : double affichage du label
            AssociationField::new('reference_fk', 'Référence Association field du produitcrudcontroller')->autocomplete()->renderAsEmbeddedForm(
                ReferencesCrudController::class,'ajouter une ref'
            ),
//            ajout du formulaire imbriqué juste au dessus (un input appele le refcrudcontroler qui permet de créer une nouvelle ref pour echapper au onetoone
            AssociationField::new('categorie_fk', 'Catégorie')->autocomplete(),
            AssociationField::new('distributeur_fk', 'Distributeur')->autocomplete()->onlyOnForms(),
            ArrayField::new('distributeur_fk', 'Distributeur')->onlyOnIndex(),
            AssociationField::new('user_fk', 'Utilisateur')->autocomplete(),
            DateTimeField::new('createdAt', 'Créé le')->onlyOnIndex(),
            DateTimeField::new('updatedAt', 'MAJ le')->onlyOnIndex(),
        ];
    }

}
