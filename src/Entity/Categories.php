<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Produits>
     */

//   ajout pour bug d'ajout dans l'admin (pas de lien avec produit)
    #[ORM\OneToMany(targetEntity: Produits::class, mappedBy: 'categorie_fk')]
    private Collection $produits;
//    __________

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    //   ajout pour bug d'ajout dans l'admin (pas de lien avec produit)
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produits $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->addCategorieFk($this);
        }

        return $this;
    }

    public function removeProduit(Produits $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            $produit->removeCategorieFk($this);
        }

        return $this;
    }
//    _________________________
}

