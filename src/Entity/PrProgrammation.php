<?php

namespace App\Entity;

use App\Repository\PrProgrammationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrProgrammationRepository::class)]
class PrProgrammation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\ManyToOne(targetEntity: AcElement::class, inversedBy: 'programmations')]
    private $element;

    #[ORM\ManyToOne(targetEntity: PNatureEpreuve::class, inversedBy: 'programmations')]
    private $nature_epreuve;

    #[ORM\Column(type: 'float', nullable: true)]
    private $volume;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $observation;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $regroupe;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $categorie;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'programmations')]
    private $UserCreated;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $Updated;

    #[ORM\OneToMany(mappedBy: 'programmation', targetEntity: PlEmptime::class)]
    private $emtimes;

    #[ORM\ManyToMany(targetEntity: PEnseignant::class, mappedBy: 'programmations')]
    private $enseignants;

    #[ORM\ManyToOne(targetEntity: AcAnnee::class, inversedBy: 'programmations')]
    private $annee;

    public function __construct()
    {
        $this->emtimes = new ArrayCollection();
        $this->enseignants = new ArrayCollection();
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

    public function getElement(): ?AcElement
    {
        return $this->element;
    }

    public function setElement(?AcElement $element): self
    {
        $this->element = $element;

        return $this;
    }

    public function getNatureEpreuve(): ?PNatureEpreuve
    {
        return $this->nature_epreuve;
    }

    public function setNatureEpreuve(?PNatureEpreuve $nature_epreuve): self
    {
        $this->nature_epreuve = $nature_epreuve;

        return $this;
    }

    public function getVolume(): ?float
    {
        return $this->volume;
    }

    public function setVolume(?float $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    public function getRegroupe(): ?int
    {
        return $this->regroupe;
    }

    public function setRegroupe(?int $regroupe): self
    {
        $this->regroupe = $regroupe;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getUserCreated(): ?User
    {
        return $this->UserCreated;
    }

    public function setUserCreated(?User $UserCreated): self
    {
        $this->UserCreated = $UserCreated;

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

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->Updated;
    }

    public function setUpdated(?\DateTimeInterface $Updated): self
    {
        $this->Updated = $Updated;

        return $this;
    }

    /**
     * @return Collection|PlEmptime[]
     */
    public function getEmtimes(): Collection
    {
        return $this->emtimes;
    }

    public function addEmtime(PlEmptime $emtime): self
    {
        if (!$this->emtimes->contains($emtime)) {
            $this->emtimes[] = $emtime;
            $emtime->setProgrammation($this);
        }

        return $this;
    }

    public function removeEmtime(PlEmptime $emtime): self
    {
        if ($this->emtimes->removeElement($emtime)) {
            // set the owning side to null (unless already changed)
            if ($emtime->getProgrammation() === $this) {
                $emtime->setProgrammation(null);
            }
        }

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
            $enseignant->addProgrammation($this);
        }

        return $this;
    }

    public function removeEnseignant(PEnseignant $enseignant): self
    {
        if ($this->enseignants->removeElement($enseignant)) {
            $enseignant->removeProgrammation($this);
        }

        return $this;
    }

    public function getAnnee(): ?AcAnnee
    {
        return $this->annee;
    }

    public function setAnnee(?AcAnnee $annee): self
    {
        $this->annee = $annee;

        return $this;
    }
}
