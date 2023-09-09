<?php

namespace App\Entity;

use App\Repository\PlEmptimeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlEmptimeRepository::class)]
class PlEmptime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\ManyToOne(targetEntity: PrProgrammation::class, inversedBy: 'emtimes')]
    private $programmation;

    #[ORM\ManyToOne(targetEntity: Semaine::class, inversedBy: 'emptimes')]
    private $semaine;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateemploi;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $start;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $end;

    #[ORM\Column(type: 'time', nullable: true)]
    private $heur_db;

    #[ORM\Column(type: 'time', nullable: true)]
    private $heur_fin;

    #[ORM\Column(type: 'float', nullable: true)]
    private $valider = 0;

    #[ORM\Column(type: 'float', nullable: true)]
    private $annuler = 0;

    #[ORM\Column(type: 'float', nullable: true)]
    private $generer = 0;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $motif_annuler;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'emptimes')]
    private $UserCreated;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'emptimes')]
    private $UserUpdated;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $Created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $Updated;

    #[ORM\ManyToOne(targetEntity: PSalles::class, inversedBy: 'emptimes')]
    private $salle;

    // #[ORM\ManyToOne(targetEntity: Color::class, inversedBy: 'emptimes')]
    // private $color;

    #[ORM\ManyToOne(targetEntity: PGroupe::class, inversedBy: 'emptimes')]
    private $groupe;

    #[ORM\OneToMany(mappedBy: 'seance', targetEntity: ISeance::class)]
    private $iSeances;

    #[ORM\OneToMany(mappedBy: 'seance', targetEntity: PlEmptimens::class)]
    private $emptimens;

    #[ORM\Column(type: 'float', nullable: true)]
    private $active = 1;

    #[ORM\OneToMany(mappedBy: 'seance', targetEntity: HHonens::class)]
    private $honenss;

    #[ORM\ManyToOne(targetEntity: PSalles::class, inversedBy: 'plEmptimes')]
    private $xsalle;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'plEmptimes')]
    private $userDeleted;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $deleted;
    
    public function __construct()
    {
        $this->iSeances = new ArrayCollection();
        $this->emptimens = new ArrayCollection();
        $this->honenss = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getProgrammation(): ?PrProgrammation
    {
        return $this->programmation;
    }

    public function setProgrammation(?PrProgrammation $programmation): self
    {
        $this->programmation = $programmation;

        return $this;
    }

    public function getSemaine(): ?Semaine
    {
        return $this->semaine;
    }

    public function setSemaine(?Semaine $semaine): self
    {
        $this->semaine = $semaine;

        return $this;
    }

    public function getDateemploi(): ?\DateTimeInterface
    {
        return $this->dateemploi;
    }

    public function setDateemploi(?\DateTimeInterface $dateemploi): self
    {
        $this->dateemploi = $dateemploi;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(?\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getHeurDb(): ?\DateTimeInterface
    {
        return $this->heur_db;
    }

    public function setHeurDb(?\DateTimeInterface $heur_db): self
    {
        $this->heur_db = $heur_db;

        return $this;
    }

    public function getHeurFin(): ?\DateTimeInterface
    {
        return $this->heur_fin;
    }

    public function setHeurFin(?\DateTimeInterface $heur_fin): self
    {
        $this->heur_fin = $heur_fin;

        return $this;
    }

    public function getValider(): ?float
    {
        return $this->valider;
    }

    public function setValider(?float $valider): self
    {
        $this->valider = $valider;

        return $this;
    }

    public function getAnnuler(): ?float
    {
        return $this->annuler;
    }

    public function setAnnuler(?float $annuler): self
    {
        $this->annuler = $annuler;

        return $this;
    }

    public function getGenerer(): ?float
    {
        return $this->generer;
    }

    public function setGenerer(?float $generer): self
    {
        $this->generer = $generer;

        return $this;
    }

    public function getMotifAnnuler(): ?string
    {
        return $this->motif_annuler;
    }

    public function setMotifAnnuler(?string $motif_annuler): self
    {
        $this->motif_annuler = $motif_annuler;

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

    public function getUserUpdated(): ?User
    {
        return $this->UserUpdated;
    }

    public function setUserUpdated(?User $UserUpdated): self
    {
        $this->UserUpdated = $UserUpdated;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->Created;
    }

    public function setCreated(?\DateTimeInterface $Created): self
    {
        $this->Created = $Created;

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

    public function getSalle(): ?PSalles
    {
        return $this->salle;
    }

    public function setSalle(?PSalles $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    // public function getColor(): ?Color
    // {
    //     return $this->color;
    // }

    // public function setColor(?Color $color): self
    // {
    //     $this->color = $color;

    //     return $this;
    // }

    public function getGroupe(): ?PGroupe
    {
        return $this->groupe;
    }

    public function setGroupe(?PGroupe $groupe): self
    {
        $this->groupe = $groupe;

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
            $iSeance->setSeance($this);
        }

        return $this;
    }

    public function removeISeance(ISeance $iSeance): self
    {
        if ($this->iSeances->removeElement($iSeance)) {
            // set the owning side to null (unless already changed)
            if ($iSeance->getSeance() === $this) {
                $iSeance->setSeance(null);
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
            $emptimen->setSeance($this);
        }

        return $this;
    }

    public function removeEmptimen(PlEmptimens $emptimen): self
    {
        if ($this->emptimens->removeElement($emptimen)) {
            // set the owning side to null (unless already changed)
            if ($emptimen->getSeance() === $this) {
                $emptimen->setSeance(null);
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

    public function getXsalle(): ?PSalles
    {
        return $this->xsalle;
    }

    public function setXsalle(?PSalles $xsalle): self
    {
        $this->xsalle = $xsalle;

        return $this;
    }

    public function getUserDeleted(): ?User
    {
        return $this->userDeleted;
    }

    public function setUserDeleted(?User $userDeleted): self
    {
        $this->userDeleted = $userDeleted;

        return $this;
    }

    public function getDeleted(): ?\DateTimeInterface
    {
        return $this->deleted;
    }

    public function setDeleted(?\DateTimeInterface $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

}
