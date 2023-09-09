<?php

namespace App\Entity;

use App\Repository\PBatimentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PBatimentsRepository::class)]
class PBatiments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $abreviation;

    #[ORM\OneToMany(mappedBy: 'batiment', targetEntity: PEtages::class)]
    private $etages;

    public function __construct()
    {
        $this->etages = new ArrayCollection();
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

    public function getAbreviation(): ?string
    {
        return $this->abreviation;
    }

    public function setAbreviation(?string $abreviation): self
    {
        $this->abreviation = $abreviation;

        return $this;
    }

    /**
     * @return Collection|PEtages[]
     */
    public function getEtages(): Collection
    {
        return $this->etages;
    }

    public function addEtage(PEtages $etage): self
    {
        if (!$this->etages->contains($etage)) {
            $this->etages[] = $etage;
            $etage->setBatiment($this);
        }

        return $this;
    }

    public function removeEtage(PEtages $etage): self
    {
        if ($this->etages->removeElement($etage)) {
            // set the owning side to null (unless already changed)
            if ($etage->getBatiment() === $this) {
                $etage->setBatiment(null);
            }
        }

        return $this;
    }
}
