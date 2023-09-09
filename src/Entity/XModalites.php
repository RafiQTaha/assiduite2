<?php

namespace App\Entity;

use App\Repository\XModalitesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: XModalitesRepository::class)]
class XModalites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\OneToMany(mappedBy: 'paiement', targetEntity: TReglement::class)]
    private $reglements;

    #[ORM\OneToMany(mappedBy: 'modalite', targetEntity: TBrdpaiement::class)]
    private $bordereaux;

    #[ORM\Column(type: 'float', nullable: true)]
    private $active;

    public function __construct()
    {
        $this->reglements = new ArrayCollection();
        $this->bordereaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection|TReglement[]
     */
    public function getReglements(): Collection
    {
        return $this->reglements;
    }

    public function addReglement(TReglement $reglement): self
    {
        if (!$this->reglements->contains($reglement)) {
            $this->reglements[] = $reglement;
            $reglement->setPaiement($this);
        }

        return $this;
    }

    public function removeReglement(TReglement $reglement): self
    {
        if ($this->reglements->removeElement($reglement)) {
            // set the owning side to null (unless already changed)
            if ($reglement->getPaiement() === $this) {
                $reglement->setPaiement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TBrdpaiement[]
     */
    public function getBordereaux(): Collection
    {
        return $this->bordereaux;
    }

    public function addBordereaux(TBrdpaiement $bordereaux): self
    {
        if (!$this->bordereaux->contains($bordereaux)) {
            $this->bordereaux[] = $bordereaux;
            $bordereaux->setModalite($this);
        }

        return $this;
    }

    public function removeBordereaux(TBrdpaiement $bordereaux): self
    {
        if ($this->bordereaux->removeElement($bordereaux)) {
            // set the owning side to null (unless already changed)
            if ($bordereaux->getModalite() === $this) {
                $bordereaux->setModalite(null);
            }
        }

        return $this;
    }

    public function getActive(): ?float
    {
        return $this->active;
    }

    public function setActive(?float $active): self
    {
        $this->active = $active;

        return $this;
    }
}
