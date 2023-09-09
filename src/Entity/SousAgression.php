<?php

namespace App\Entity;

use App\Repository\SousAgressionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousAgressionRepository::class)]
class SousAgression
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\ManyToOne(targetEntity: Agression::class, inversedBy: 'sousAgressions')]
    private $agression;

    #[ORM\Column(type: 'float', nullable: true)]
    private $active;

    #[ORM\OneToMany(mappedBy: 'agression', targetEntity: InsSanctionner::class)]
    private $insSanctionners;

    public function __construct()
    {
        $this->insSanctionners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAgression(): ?Agression
    {
        return $this->agression;
    }

    public function setAgression(?Agression $agression): self
    {
        $this->agression = $agression;

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

    /**
     * @return Collection<int, InsSanctionner>
     */
    public function getInsSanctionners(): Collection
    {
        return $this->insSanctionners;
    }

    public function addInsSanctionner(InsSanctionner $insSanctionner): self
    {
        if (!$this->insSanctionners->contains($insSanctionner)) {
            $this->insSanctionners[] = $insSanctionner;
            $insSanctionner->setAgression($this);
        }

        return $this;
    }

    public function removeInsSanctionner(InsSanctionner $insSanctionner): self
    {
        if ($this->insSanctionners->removeElement($insSanctionner)) {
            // set the owning side to null (unless already changed)
            if ($insSanctionner->getAgression() === $this) {
                $insSanctionner->setAgression(null);
            }
        }

        return $this;
    }
}
