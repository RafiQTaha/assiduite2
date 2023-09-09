<?php

namespace App\Entity;

use App\Repository\AgressionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgressionRepository::class)]
class Agression
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\Column(type: 'float', nullable: true)]
    private $active;

    #[ORM\OneToMany(mappedBy: 'agression', targetEntity: SousAgression::class)]
    private $sousAgressions;

    #[ORM\OneToMany(mappedBy: 'agression', targetEntity: Sanction::class)]
    private $sanctions;

    public function __construct()
    {
        $this->sousAgressions = new ArrayCollection();
        $this->sanctions = new ArrayCollection();
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
     * @return Collection<int, SousAgression>
     */
    public function getSousAgressions(): Collection
    {
        return $this->sousAgressions;
    }

    public function addSousAgression(SousAgression $sousAgression): self
    {
        if (!$this->sousAgressions->contains($sousAgression)) {
            $this->sousAgressions[] = $sousAgression;
            $sousAgression->setAgression($this);
        }

        return $this;
    }

    public function removeSousAgression(SousAgression $sousAgression): self
    {
        if ($this->sousAgressions->removeElement($sousAgression)) {
            // set the owning side to null (unless already changed)
            if ($sousAgression->getAgression() === $this) {
                $sousAgression->setAgression(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sanction>
     */
    public function getSanctions(): Collection
    {
        return $this->sanctions;
    }

    public function addSanction(Sanction $sanction): self
    {
        if (!$this->sanctions->contains($sanction)) {
            $this->sanctions[] = $sanction;
            $sanction->setAgression($this);
        }

        return $this;
    }

    public function removeSanction(Sanction $sanction): self
    {
        if ($this->sanctions->removeElement($sanction)) {
            // set the owning side to null (unless already changed)
            if ($sanction->getAgression() === $this) {
                $sanction->setAgression(null);
            }
        }

        return $this;
    }

}
