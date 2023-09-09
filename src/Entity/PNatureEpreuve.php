<?php

namespace App\Entity;

use App\Repository\PNatureEpreuveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PNatureEpreuveRepository::class)]
class PNatureEpreuve
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

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $type;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nature;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $examen;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $mapped;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $absence;

    #[ORM\OneToMany(mappedBy: 'natureEpreuve', targetEntity: AcEpreuve::class)]
    private $epreuves;

    #[ORM\OneToMany(mappedBy: 'nature_epreuve', targetEntity: PrProgrammation::class)]
    private $programmations;

    #[ORM\OneToMany(mappedBy: 'type_epreuve', targetEntity: PEnsgrille::class)]
    private $ensgrilles;

    public function __construct()
    {
        $this->epreuves = new ArrayCollection();
        $this->programmations = new ArrayCollection();
        $this->ensgrilles = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function setNature(?string $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    public function getExamen(): ?int
    {
        return $this->examen;
    }

    public function setExamen(?int $examen): self
    {
        $this->examen = $examen;

        return $this;
    }

    public function getMapped(): ?string
    {
        return $this->mapped;
    }

    public function setMapped(?string $mapped): self
    {
        $this->mapped = $mapped;

        return $this;
    }

    public function getAbsence(): ?bool
    {
        return $this->absence;
    }

    public function setAbsence(?bool $absence): self
    {
        $this->absence = $absence;

        return $this;
    }

    /**
     * @return Collection|AcEpreuve[]
     */
    public function getEpreuves(): Collection
    {
        return $this->epreuves;
    }

    public function addEpreufe(AcEpreuve $epreufe): self
    {
        if (!$this->epreuves->contains($epreufe)) {
            $this->epreuves[] = $epreufe;
            $epreufe->setNatureEpreuve($this);
        }

        return $this;
    }

    public function removeEpreufe(AcEpreuve $epreufe): self
    {
        if ($this->epreuves->removeElement($epreufe)) {
            // set the owning side to null (unless already changed)
            if ($epreufe->getNatureEpreuve() === $this) {
                $epreufe->setNatureEpreuve(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PrProgrammation[]
     */
    public function getProgrammations(): Collection
    {
        return $this->programmations;
    }

    public function addProgrammation(PrProgrammation $programmation): self
    {
        if (!$this->programmations->contains($programmation)) {
            $this->programmations[] = $programmation;
            $programmation->setNatureEpreuve($this);
        }

        return $this;
    }

    public function removeProgrammation(PrProgrammation $programmation): self
    {
        if ($this->programmations->removeElement($programmation)) {
            // set the owning side to null (unless already changed)
            if ($programmation->getNatureEpreuve() === $this) {
                $programmation->setNatureEpreuve(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PEnsgrille>
     */
    public function getEnsgrilles(): Collection
    {
        return $this->ensgrilles;
    }

    public function addEnsgrille(PEnsgrille $ensgrille): self
    {
        if (!$this->ensgrilles->contains($ensgrille)) {
            $this->ensgrilles[] = $ensgrille;
            $ensgrille->setTypeEpreuve($this);
        }

        return $this;
    }

    public function removeEnsgrille(PEnsgrille $ensgrille): self
    {
        if ($this->ensgrilles->removeElement($ensgrille)) {
            // set the owning side to null (unless already changed)
            if ($ensgrille->getTypeEpreuve() === $this) {
                $ensgrille->setTypeEpreuve(null);
            }
        }

        return $this;
    }
}
