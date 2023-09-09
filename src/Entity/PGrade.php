<?php

namespace App\Entity;

use App\Repository\PGradeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PGradeRepository::class)]
class PGrade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $abreviation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\OneToMany(mappedBy: 'grade', targetEntity: PEnseignant::class)]
    private $enseignants;

    #[ORM\OneToMany(mappedBy: 'grade', targetEntity: PEnsgrille::class)]
    private $ensgrilles;

    public function __construct()
    {
        $this->enseignants = new ArrayCollection();
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

    public function getAbreviation(): ?string
    {
        return $this->abreviation;
    }

    public function setAbreviation(?string $abreviation): self
    {
        $this->abreviation = $abreviation;

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
     * @return Collection|PEnseignant[]
     */
    public function getEnseignants(): Collection
    {
        return $this->enseignants;
    }

    public function addEnseignant(PEnseignant $enseignant): self
    {
        if (!$this->enseignants->contains($enseignant)) {
            $this->enseignants[] = $enseignant;
            $enseignant->setGrade($this);
        }

        return $this;
    }

    public function removeEnseignant(PEnseignant $enseignant): self
    {
        if ($this->enseignants->removeElement($enseignant)) {
            // set the owning side to null (unless already changed)
            if ($enseignant->getGrade() === $this) {
                $enseignant->setGrade(null);
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
            $ensgrille->setGrade($this);
        }

        return $this;
    }

    public function removeEnsgrille(PEnsgrille $ensgrille): self
    {
        if ($this->ensgrilles->removeElement($ensgrille)) {
            // set the owning side to null (unless already changed)
            if ($ensgrille->getGrade() === $this) {
                $ensgrille->setGrade(null);
            }
        }

        return $this;
    }
}
