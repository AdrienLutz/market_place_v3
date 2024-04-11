<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Entity\CommandesDetails;
use App\Repository\CommandesDetailsRepository;
use App\Repository\CommandesRepository;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CommandesController extends AbstractController
{
    #[Route('/commandes', name: 'app_valider_commander')]
    // méthode utilisée dans afficher_panier.html.twig
    public function ajouterCommande(
        SessionInterface $session,
        ProduitsRepository $produitsRepository,
        EntityManagerInterface $em): Response {
        // imposer une connexion utlisateur
        $this->denyAccessUnlessGranted('ROLE_USER');
        // recupérer le panier grâce à SessionInterface
        $panier = $session->get('panier', []);
        // créer la commande (panier non vide)
        $commande = new Commandes();
        $commande ->setUser($this->getUser());
        $commande->setNumeroCmd(uniqid());
        $total=0;

        //TODO : $item a besoin d'être déclaré ? Si oui, comme ceci ?
        $item=0;
        // parcourir le panier par référence pour obtenir les détails
        foreach ($panier as $item -> $quantite){
            $commande_details = new CommandesDetails();
            $produit = $produitsRepository ->find($item);
            $price = $produit->getPrice();
            $commande_details->setProduits($produit);
            $commande_details->setPrice($price);
            $commande_details->setQuantite($quantite);
            // ajouter des détails à la commande principale (parente)
            $commande->addCommandeDetail($commande_details);
        }

        $em->persist($commande);
        $em->flush();

        // vider le panier
        $session->remove('panier');
        $this->addFlash('succes', 'Votre commande a bien été validée !');
        return $this->redirectToRoute('app_resume_commande');
    }

    #[Route('/resume_commandes/{numero_commande}', 'app_resume_commandes')]
    public function resumeCommande(
        CommandesRepository $commandesRepository,
        CommandesDetailsRepository $commandesDetailsRepository,
        Commandes $commandes): Response
    {
        return $this->render('commandes/resume-commande.html.twig',[
            'commandes' => $commandesRepository-> findAll(),
            'details_commande' => $commandesDetailsRepository->findBy(['commande'=>$commandes])
        ]);
    }

    #[Route('/historique_commandes}', 'app_afficher_commandes')]
    public function historiqueCommandes(CommandesRepository $commandesRepository): Response
    {
        $commandes = $commandesRepository-> findAll();
        return $this->render('commandes/historique-commandes.html.twig',[
        'commandes' => $commandes
        ]);
    }
}
