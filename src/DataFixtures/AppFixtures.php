<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Produits;
use App\Entity\Categories;
use App\Entity\References;
use App\Entity\User;
use App\Entity\Distributeurs;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

//use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $produits = [];
        $categories = [];
        $distributeurs = [];
        $references = [];
        $users = [];

        for ($i = 0; $i < 30; $i++) {
            $reference = new References();
            $reference->setName('REF_' . mt_rand(1, 9999));
            $references[] = $reference;
            $manager->persist($reference);
        }
        for ($i = 0; $i < 30; $i++) {
            $user = new User();
            $user->setEmail('user'.$i.'@mail.fr');
            $user->setPassword('azerty');
            $user->setRoles(['ROLE_USER']);
            $user->setfirstName('firstName'.$i);
            $user->setlastName('lastName'.$i);
            $user->setVerified(true);
            $users[] = $user;
            $manager->persist($user);
        }


        for ($i = 0; $i < 30; $i++) {
            $categorie = new Categories();
            $categorie->setName($faker->word);
            $categories[] = $categorie;
            $manager->persist($categorie);
        }

        for ($i = 0; $i < 30; $i++) {
            $distributeur = new Distributeurs();
            $distributeur->setName($faker->word);
            $distributeurs[] = $distributeur;
            $manager->persist($distributeur);
        }

        for ($i = 0; $i < 30; $i++) {

            $produit = new Produits();
            $produit->setName($faker->word);

            for ($c = 0; $c < count($categories); $c++) {
                $produit->setCategorieFk($faker->randomElement($categories));
            }

            for ($d = 0; $d < count($distributeurs); $d++) {
                $produit->addDistributeurFk($faker->randomElement($distributeurs));
            }

            for ($r = 0; $r < count($references); $r++) {
                $produit->setReferenceFk($references[$i]);
            }

            for ($u = 0; $u < count($users); $u++) {
                $produit->setUserFk($users[$i]);
            }

            $produits[] = $produit;
            $manager->persist($produit);

        }



//         $product = new Product();
//         $manager->persist($product);

         $manager->flush();
    }
}