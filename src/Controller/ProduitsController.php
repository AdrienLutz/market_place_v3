<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Entity\Categories;
use App\Entity\Distributeurs;
use App\Entity\References;
use App\Form\ProduitsType;
use App\Repository\ProduitsRepository;
use App\Repository\CategoriesRepository;
use App\Repository\ReferencesRepository;
use App\Repository\DistributeursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/index')]
class ProduitsController extends AbstractController
{
//    #[Route('/', name: 'app_produits_index', methods: ['GET'])]
//    public function index(ProduitsRepository $produitsRepository): Response
//    {
//        return $this->render('produits/index.html.twig', [
//            'produits' => $produitsRepository->findAll(),
//        ]);
//    }

    #[Route('/produits', name: 'app_produits')]
    #[IsGranted('ROLE_USER')]
    public function AfficherProduits(
        ProduitsRepository $produitsRepository,
        CategoriesRepository $categoriesRepository,
        DistributeursRepository$distributeursRepository,
    ): Response{
        // récupérer l'utilisateur connecté
        $user = $this->getUser();
        return $this->render('produits/afficher_produits.html.twig', [
            //filter les produits par utilisateur
            "produits" => $produitsRepository-> findBy(['user_fk'=> $user]),
            "categories" => $categoriesRepository ->findAll(),
            "distributeurs" => $distributeursRepository -> findAll(),
        ]);
    }

    #[Route('/new', name: 'app_produits_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produits/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produits_show', methods: ['GET'])]
    public function show(Produits $produit): Response
    {
        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produits_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produits/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produits_delete', methods: ['POST'])]
    public function delete(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
    }
}
