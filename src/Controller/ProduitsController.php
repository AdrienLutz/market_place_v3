<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\DistributeursRepository;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class ProduitsController extends AbstractController
{
    #[Route('/produits', name: 'app_produits')]
    #[IsGranted('ROLE_USER')]
    public function AfficherProduits(
        ProduitsRepository $produitsRepository,
        CategoriesRepository $categoriesRepository,
        DistributeursRepository$distributeursRepository,
    ): Response{
        // récupérer l'utilisateur connecter
        $user = $this->getUser();
        return $this->render('produits/afficher_produits.html.twig', [
            //filter les produits par utilisateur
            "produits" => $produitsRepository-> findBy(['user_fk'=> $user]),
            "categorie" => $categoriesRepository ->findAll(),
            "distributeurs" => $distributeursRepository -> findAll(),
        ]);
    }
    
}
