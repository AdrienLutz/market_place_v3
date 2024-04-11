<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Distributeurs;
use App\Entity\Produits;
use App\Entity\References;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('price')
            ->add('image')
            ->add('reference_fk', EntityType::class, [
                'class' => References::class,
                'choice_label' => 'id',
            ])
            ->add('distributeur_fk', EntityType::class, [
                'class' => Distributeurs::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('categorie_fk', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'id',
            ])
            ->add('user_fk', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
