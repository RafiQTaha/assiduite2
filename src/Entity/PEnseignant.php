<?php

namespace App\Entity;

use App\Repository\PEnseignantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PEnseignantRepository::class)]
class PEnseignant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $prenom;

    #[ORM\ManyToOne(targetEntity: PGrade::class, inversedBy: 'enseignants')]
    private $grade;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\OneToMany(mappedBy: 'enseignant', targetEntity: AcEpreuve::class)]
    private $epreuves;

    #[ORM\ManyToMany(targetEntity: PrProgrammation::class, inversedBy: 'enseignants')]
    private $programmations;

    #[ORM\OneToMany(mappedBy: 'enseignant', targetEntity: ISeance::class)]
    private $iSeances;

    #[ORM\OneToMany(mappedBy: 'enseignant', targetEntity: PlEmptimens::class)]
    private $emptimens;

    #[ORM\OneToMany(mappedBy: 'enseignant', targetEntity: HHonens::class)]
    private $honenss;

    #[ORM\OneToMany(mappedBy: 'enseignant', targetEntity: PEnseignantExcept::class)]
    private $enseignantexcepts;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $active = 1;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $Cin;

    #[ORM\Column(type: 'string', length: 24, nullable: true)]
    private $Rib;

    public function __construct()
    {
        $this->epreuves = new ArrayCollection();
        $this->programmations = new ArrayCollection();
        $this->iSeances = new ArrayCollection();
        $this->emptimens = new ArrayCollection();
        $this->honenss = new ArrayCollection();
        $this->enseignantexcepts = new ArrayCollection();
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getGrade(): ?PGrade
    {
        return $this->grade;
    }

    public function setGrade(?PGrade $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

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
            $epreufe->setEnseignant($this);
        }

        return $this;
    }

    public function removeEpreufe(AcEpreuve $epreufe): self
    {
        if ($this->epreuves->removeElement($epreufe)) {
            // set the owning side to null (unless already changed)
            if ($epreufe->getEnseignant() === $this) {
                $epreufe->setEnseignant(null);
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
        }

        return $this;
    }

    public function removeProgrammation(PrProgrammation $programmation): self
    {
        $this->programmations->removeElement($programmation);

        return $this;
    }

    /**
     * @return Collection<int, ISeance>
     */
    public function getISeances(): Collection
    {
        return $this->iSeances;
    }

    public function addISeance(ISeance $iSeance): self
    {
        if (!$this->iSeances->contains($iSeance)) {
            $this->iSeances[] = $iSeance;
            $iSeance->setEnseignant($this);
        }

        return $this;
    }

    public function removeISeance(ISeance $iSeance): self
    {
        if ($this->iSeances->removeElement($iSeance)) {
            // set the owning side to null (unless already changed)
            if ($iSeance->getEnseignant() === $this) {
                $iSeance->setEnseignant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlEmptimens>
     */
    public function getEmptimens(): Collection
    {
        return $this->emptimens;
    }

    public function addEmptimen(PlEmptimens $emptimen): self
    {
        if (!$this->emptimens->contains($emptimen)) {
            $this->emptimens[] = $emptimen;
            $emptimen->setEnseignant($this);
        }

        return $this;
    }

    public function removeEmptimen(PlEmptimens $emptimen): self
    {
        if ($this->emptimens->removeElement($emptimen)) {
            // set the owning side to null (unless already changed)
            if ($emptimen->getEnseignant() === $this) {
                $emptimen->setEnseignant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HHonens>
     */
    public function getHonenss(): Collection
    {
        return $this->honenss;
    }

    public function addHonenss(HHonens $honenss): self
    {
        if (!$this->honenss->contains($honenss)) {
            $this->honenss[] = $honenss;
            $honenss->setUserCreated($this);
        }

        return $this;
    }

    public function removeHonenss(HHonens $honenss): self
    {
        if ($this->honenss->removeElement($honenss)) {
            // set the owning side to null (unless already changed)
            if ($honenss->getUserCreated() === $this) {
                $honenss->setUserCreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PEnseignantExcept>
     */
    public function getEnseignantexcepts(): Collection
    {
        return $this->enseignantexcepts;
    }

    public function addEnseignantexcept(PEnseignantExcept $enseignantexcept): self
    {
        if (!$this->enseignantexcepts->contains($enseignantexcept)) {
            $this->enseignantexcepts[] = $enseignantexcept;
            $enseignantexcept->setEnseignant($this);
        }

        return $this;
    }

    public function removeEnseignantexcept(PEnseignantExcept $enseignantexcept): self
    {
        if ($this->enseignantexcepts->removeElement($enseignantexcept)) {
            // set the owning side to null (unless already changed)
            if ($enseignantexcept->getEnseignant() === $this) {
                $enseignantexcept->setEnseignant(null);
            }
        }

        return $this;
    }
    
    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(?int $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->Cin;
    }

    public function setCin(?string $Cin): self
    {
        $this->Cin = $Cin;

        return $this;
    }

    public function getRib(): ?string
    {
        return $this->Rib;
    }

    public function setRib(?string $Rib): self
    {
        $this->Rib = $Rib;

        return $this;
    }
}
