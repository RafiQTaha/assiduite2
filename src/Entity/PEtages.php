<?php

namespace App\Entity;

use App\Repository\PEtagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PEtagesRepository::class)]
class PEtages
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

    #[ORM\ManyToOne(targetEntity: PBatiments::class, inversedBy: 'etages')]
    private $batiment;

    #[ORM\OneToMany(mappedBy: 'etage', targetEntity: PSalles::class)]
    private $salles;

    public function __construct()
    {
        $this->salles = new ArrayCollection();
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

    public function getBatiment(): ?PBatiments
    {
        return $this->batiment;
    }

    public function setBatiment(?PBatiments $batiment): self
    {
        $this->batiment = $batiment;

        return $this;
    }

    /**
     * @return Collection|PSalles[]
     */
    public function getSalles(): Collection
    {
        return $this->salles;
    }

    public function addSalle(PSalles $salle): self
    {
        if (!$this->salles->contains($salle)) {
            $this->salles[] = $salle;
            $salle->setEtage($this);
        }

        return $this;
    }

    public function removeSalle(PSalles $salle): self
    {
        if ($this->salles->removeElement($salle)) {
            // set the owning side to null (unless already changed)
            if ($salle->getEtage() === $this) {
                $salle->setEtage(null);
            }
        }

        return $this;
    }
}
