<?php

namespace App\Entity;

use App\Repository\PMatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PMatiereRepository::class)]
class PMatiere
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

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $active;

    #[ORM\OneToMany(mappedBy: 'matiere', targetEntity: TPreinscriptionReleveNote::class)]
    private $tPreinscritionReleveNotes;

    public function __construct()
    {
        $this->tPreinscritionReleveNotes = new ArrayCollection();
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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|TPreinscriptionReleveNote[]
     */
    public function getTPreinscritionReleveNotes(): Collection
    {
        return $this->tPreinscritionReleveNotes;
    }

    public function addTPreinscritionReleveNote(TPreinscriptionReleveNote $tPreinscritionReleveNote): self
    {
        if (!$this->tPreinscritionReleveNotes->contains($tPreinscritionReleveNote)) {
            $this->tPreinscritionReleveNotes[] = $tPreinscritionReleveNote;
            $tPreinscritionReleveNote->setMatiere($this);
        }

        return $this;
    }

    public function removeTPreinscritionReleveNote(TPreinscriptionReleveNote $tPreinscritionReleveNote): self
    {
        if ($this->tPreinscritionReleveNotes->removeElement($tPreinscritionReleveNote)) {
            // set the owning side to null (unless already changed)
            if ($tPreinscritionReleveNote->getMatiere() === $this) {
                $tPreinscritionReleveNote->setMatiere(null);
            }
        }

        return $this;
    }
}
