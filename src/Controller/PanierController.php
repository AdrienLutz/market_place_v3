<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Produits;

class PanierController extends AbstractController
{

    #[Route('/ajouter_au_panier/{id}', name: 'app_panier')]
    public function ajouterAuPanier(Produits $produits, SessionInterface $session): Response
    {

        // récupérer l'id du produit concerné
        $produit_id = $produits->getId();
        // récupérer le panier existant (vide par défaut) à l'aide du getter de la session
        $panier = $session->get('panier', []);

        // Si le panier est vide, on ajoute l'id sinon on incrémente
        if (empty($panier[$produit_id])) {
            $panier[$produit_id] = 1;
        } else {
            $panier[$produit_id]++;
        }
        // ajouter la panier à la session à l'aide du setter
        $session->set('panier', $panier);

        return $this->redirectToRoute('app_afficher_panier');
    }


    #[Route('/afficher_panier', name: 'app_afficher_panier')]
    public function afficherPanier(SessionInterface $session, ProduitsRepository $produitsRepository): Response
    {

        // récupérer le panier à partir de la session
        $panier = $session->get('panier', []);
        // stocker les produits de la session dans un nouveau tableau
        $commande = [];
        // calculer le total de la commande
        $total = 0;

        //itérer la valeur du tableau de produits par reférences (quantité)
        foreach ($panier as $id => $quantite) {
            // récupérer un produit
            $produit = $produitsRepository->find($id);
            // stocker la commande dans un tableau associatif (clé:valeur)
            $commande[] = [
                'produit' => $produit,
                'quantite' => $quantite
            ];
            // calculer le total de la commande
            $total += $produit->getPrice() * $quantite;
        }

        return $this->render('panier/afficher_panier.html.twig', [
            'panier' => $commande,
            'total' => $total
        ]);
    }

    #[Route('/afficher_quantité_panier/{id}', 'app_ajouter_quantite_panier')]
    public function ajouterQuantitePanier(Produits $produits, SessionInterface $session):Response
    {
        // récupérer l'id du produit concerné
        $produit_id = $produits->getId();
        // récupérer le panier existant (vide par défaut) à l'aide du getter de la session
        $panier = $session->get('panier', []);

        // Si le panier est vide, on ajoute l'id sinon on incrémente
        if (empty($panier[$produit_id])) {
            $panier[$produit_id] = 1;
        } else {
            $panier[$produit_id]++;
        }
        // ajouter la panier à la session à l'aide du setter
        $session->set('panier', $panier);

        return $this->redirectToRoute('app_afficher_panier');
    }


    #[Route('/supprimer_quantité_panier/{id}', 'app_supprimer_quantite_panier')]
    public function supprimerQuantitePanier(
        Produits $produits,
        SessionInterface $session):Response {
        // récupérer l'id du produit concerné
        $produit_id = $produits->getId();
        // récupérer le panier existant (vide par défaut) à l'aide du getter de la session
        $panier = $session->get('panier', []);

        // retirer le produit du panier s'il n'y a qu'une seul exemplaire, sinon decrémenter
        if (!empty($panier[$produit_id])) {
            if ($panier[$produit_id] > 1) {
                $panier[$produit_id]--;
            } else {
                // détruire la/les variable(s) concernée(s)
                unset($panier[$produit_id]);
            }
        }
        // ajouter la panier à la session à l'aide du setter
        $session->set('panier', $panier);

        return $this->redirectToRoute('app_afficher_panier');
    }

    #[Route('/supprimer_produit_panier/{id}', 'app_supprimer_produit_panier')]
    public function supprimerProduitPanier(
        Produits $produits,
        SessionInterface $session):Response
    {
        // récupérer l'id du produit concerné
        $produit_id = $produits->getId();
        // récupérer le panier existant (vide par défaut) à l'aide du getter de la session
        $panier = $session->get('panier', []);

        // Si le panier n'est pas vide, détruire la variable de session
        if (!empty($panier[$produit_id])) {
            unset($panier[$produit_id]);
        }
        // ajouter la panier à la session à l'aide du setter
        $session->set('panier', $panier);
        $this ->addFlash('success', 'Le produit a bien été supprimé du panier !');
        return $this->redirectToRoute('app_afficher_panier');
    }

    #[Route('/vider_panier/', 'app_vider_panier')]
    public function viderPanier(SessionInterface $session):Response
    {
        $session->remove('panier');
        $this->addFlash('success', 'Votre panier a été vidé !');
        return $this->redirectToRoute('app_afficher_panier');
    }


}
