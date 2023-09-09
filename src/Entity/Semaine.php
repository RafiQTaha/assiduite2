<?php

namespace App\Entity;

use App\Repository\SemaineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SemaineRepository::class)]
class Semaine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nsemaine;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $date_debut;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $date_fin;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $tranche;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $position;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $anneeS;

    #[ORM\OneToMany(mappedBy: 'semaine', targetEntity: PlEmptime::class)]
    private $emptimes;

    #[ORM\OneToMany(mappedBy: 'semaine', targetEntity: HAlbhon::class)]
    private $albhonss;

    public function __construct()
    {
        $this->emptimes = new ArrayCollection();
        $this->albhonss = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNsemaine(): ?int
    {
        return $this->nsemaine;
    }

    public function setNsemaine(?int $nsemaine): self
    {
        $this->nsemaine = $nsemaine;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(?\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getTranche(): ?int
    {
        return $this->tranche;
    }

    public function setTranche(?int $tranche): self
    {
        $this->tranche = $tranche;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getAnneeS(): ?string
    {
        return $this->anneeS;
    }

    public function setAnneeS(?string $anneeS): self
    {
        $this->anneeS = $anneeS;

        return $this;
    }

    /**
     * @return Collection|PlEmptime[]
     */
    public function getEmptimes(): Collection
    {
        return $this->emptimes;
    }

    public function addEmptime(PlEmptime $emptime): self
    {
        if (!$this->emptimes->contains($emptime)) {
            $this->emptimes[] = $emptime;
            $emptime->setSemaine($this);
        }

        return $this;
    }

    public function removeEmptime(PlEmptime $emptime): self
    {
        if ($this->emptimes->removeElement($emptime)) {
            // set the owning side to null (unless already changed)
            if ($emptime->getSemaine() === $this) {
                $emptime->setSemaine(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HAlbhon>
     */
    public function getAlbhonss(): Collection
    {
        return $this->albhonss;
    }

    public function addAlbhonss(HAlbhon $albhonss): self
    {
        if (!$this->albhonss->contains($albhonss)) {
            $this->albhonss[] = $albhonss;
            $albhonss->setSemaine($this);
        }

        return $this;
    }

    public function removeAlbhonss(HAlbhon $albhonss): self
    {
        if ($this->albhonss->removeElement($albhonss)) {
            // set the owning side to null (unless already changed)
            if ($albhonss->getSemaine() === $this) {
                $albhonss->setSemaine(null);
            }
        }

        return $this;
    }
}
