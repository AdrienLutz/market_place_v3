<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandesRepository::class)]
class Commandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $numero_cmd = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?User $user = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, CommandesDetails>
     */
    #[ORM\OneToMany(targetEntity: CommandesDetails::class, mappedBy: 'commandes')]
    private Collection $commandesDetails;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'commande_detail')]
    private ?self $commandes = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'commandes')]
    private Collection $commande_detail;

    public function __construct()
    {
        $this->commandesDetails = new ArrayCollection();
        $this->commande_detail = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCmd(): ?string
    {
        return $this->numero_cmd;
    }

    public function setNumeroCmd(string $numero_cmd): static
    {
        $this->numero_cmd = $numero_cmd;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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

    /**
     * @return Collection<int, CommandesDetails>
     */
    public function getCommandesDetails(): Collection
    {
        return $this->commandesDetails;
    }

    public function addCommandesDetail(CommandesDetails $commandesDetail): static
    {
        if (!$this->commandesDetails->contains($commandesDetail)) {
            $this->commandesDetails->add($commandesDetail);
            $commandesDetail->setCommandes($this);
        }

        return $this;
    }

    public function removeCommandesDetail(CommandesDetails $commandesDetail): static
    {
        if ($this->commandesDetails->removeElement($commandesDetail)) {
            // set the owning side to null (unless already changed)
            if ($commandesDetail->getCommandes() === $this) {
                $commandesDetail->setCommandes(null);
            }
        }

        return $this;
    }

    public function getCommandes(): ?self
    {
        return $this->commandes;
    }

    public function setCommandes(?self $commandes): static
    {
        $this->commandes = $commandes;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getCommandeDetail(): Collection
    {
        return $this->commande_detail;
    }

    public function addCommandeDetail(self $commandeDetail): static
    {
        if (!$this->commande_detail->contains($commandeDetail)) {
            $this->commande_detail->add($commandeDetail);
            $commandeDetail->setCommandes($this);
        }

        return $this;
    }

    public function removeCommandeDetail(self $commandeDetail): static
    {
        if ($this->commande_detail->removeElement($commandeDetail)) {
            // set the owning side to null (unless already changed)
            if ($commandeDetail->getCommandes() === $this) {
                $commandeDetail->setCommandes(null);
            }
        }

        return $this;
    }
}
