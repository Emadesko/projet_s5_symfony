<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeRepository::class)]
class Demande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updateAt = null;

    #[ORM\Column]
    private ?int $etat = null;

    #[ORM\ManyToOne(inversedBy: 'demandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    /**
     * @var Collection<int, DetailDemande>
     */
    #[ORM\OneToMany(targetEntity: DetailDemande::class, mappedBy: 'damande', orphanRemoval: true)]
    private Collection $detailDemandes;

    public function __construct()
    {
        $this->detailDemandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, DetailDemande>
     */
    public function getDetailDemandes(): Collection
    {
        return $this->detailDemandes;
    }

    public function addDetailDemande(DetailDemande $detailDemande): static
    {
        if (!$this->detailDemandes->contains($detailDemande)) {
            $this->detailDemandes->add($detailDemande);
            $detailDemande->setDamande($this);
        }

        return $this;
    }

    public function removeDetailDemande(DetailDemande $detailDemande): static
    {
        if ($this->detailDemandes->removeElement($detailDemande)) {
            // set the owning side to null (unless already changed)
            if ($detailDemande->getDamande() === $this) {
                $detailDemande->setDamande(null);
            }
        }

        return $this;
    }
}
