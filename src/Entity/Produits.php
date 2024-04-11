<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// contrainte de validation
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProduitsRepository::class)]
// contrainte de validation
#[UniqueEntity(fields: ['name'], message: 'Ce nom de produit est indispensable')]
#[ORM\HasLifecycleCallbacks]
class Produits
{

    #[ORM\PrePersist]
    public function setCreatedAtValue(){
    // à la création d'un nouveau produit
    // => une date non modifiable courante est générée
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(){
    // à la maj d'un nouveau produit
    // => une date non modifiable courante est générée
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[assert\NotBlank]
    #[assert\Length(min: 2, max:50, minMessage: 'Le nom doit contenir au min {{ limit }} caractères', maxMessage: 'Le nom ne doit pas exceder {{ limit }} caractères')]
    private ?string $name = null;

    #[ORM\OneToOne(inversedBy: 'produits', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?References $reference_fk = null;



    /**
     * @var Collection<int, Distributeurs>
     */
    #[ORM\ManyToMany(targetEntity: Distributeurs::class, inversedBy: 'produits')]
    private Collection $distributeur_fk;


    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?Categories $categorie_fk = null;


    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_fk = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->distributeur_fk = new ArrayCollection();
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

    public function getReferenceFk(): ?References
    {
        return $this->reference_fk;
    }

    public function setReferenceFk(References $reference_fk): static
    {
        $this->reference_fk = $reference_fk;

        return $this;
    }

    /**
     * @return Collection<int, Distributeurs>
     */
    public function getDistributeurFk(): Collection
    {
        return $this->distributeur_fk;
    }

    public function addDistributeurFk(Distributeurs $distributeurFk): static
    {
        if (!$this->distributeur_fk->contains($distributeurFk)) {
            $this->distributeur_fk->add($distributeurFk);
        }

        return $this;
    }

    public function removeDistributeurFk(Distributeurs $distributeurFk): static
    {
        $this->distributeur_fk->removeElement($distributeurFk);

        return $this;
    }


    public function getCategorieFk(): ?Categories
    {
        return $this->categorie_fk;
    }

    public function setCategorieFk(?Categories $categorie): self
    {
        $this->categorie_fk = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(self $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setCategorieFk($this);
        }

        return $this;
    }

    public function removeProduit(self $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCategorieFk() === $this) {
                $produit->setCategorieFk(null);
            }
        }

        return $this;
    }

    public function getUserFk(): ?User
    {
        return $this->user_fk;
    }

    public function setUserFk(?User $user_fk): static
    {
        $this->user_fk = $user_fk;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function __toString(){
        return $this -> name;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
