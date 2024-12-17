<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name:"articles")]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, name:"createAt")]
    private ?\DateTime $createAt = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(name:"qteStock")]
    private ?int $qteStock = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, name:"updateAt")]
    private ?\DateTimeInterface $updateAt = null;

    /**
     * @var Collection<int, Detail>
     */
    #[ORM\OneToMany(targetEntity: Detail::class, mappedBy: 'article')]
    private Collection $details;

    /**
     * @var Collection<int, DetailDemande>
     */
    #[ORM\OneToMany(targetEntity: DetailDemande::class, mappedBy: 'article')]
    private Collection $detailDemandes;

    public function __construct()
    {
        $this->details = new ArrayCollection();
        $this->detailDemandes = new ArrayCollection();
        $this->createAt = new \DateTime;
        $this->updateAt = new \DateTime;
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

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQteStock(): ?int
    {
        return $this->qteStock;
    }

    public function setQteStock(int $qteStock): static
    {
        $this->qteStock = $qteStock;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

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

    /**
     * @return Collection<int, Detail>
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): static
    {
        if (!$this->details->contains($detail)) {
            $this->details->add($detail);
            $detail->setArticle($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): static
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getArticle() === $this) {
                $detail->setArticle(null);
            }
        }

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
            $detailDemande->setArticle($this);
        }

        return $this;
    }

    public function removeDetailDemande(DetailDemande $detailDemande): static
    {
        if ($this->detailDemandes->removeElement($detailDemande)) {
            // set the owning side to null (unless already changed)
            if ($detailDemande->getArticle() === $this) {
                $detailDemande->setArticle(null);
            }
        }

        return $this;
    }
}
