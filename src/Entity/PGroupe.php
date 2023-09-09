<?php

namespace App\Entity;

use App\Repository\PGroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PGroupeRepository::class)]
class PGroupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $niveau;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'groupes')]
    private $groupe;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: self::class)]
    private $groupes;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: TInscription::class)]
    private $inscriptions;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: PlEmptime::class)]
    private $emptimes;

    public function __construct()
    {
        $this->groupes = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->emptimes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getGroupe(): ?self
    {
        return $this->groupe;
    }

    public function setGroupe(?self $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(self $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->setGroupe($this);
        }

        return $this;
    }

    public function removeGroupe(self $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getGroupe() === $this) {
                $groupe->setGroupe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TInscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(TInscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setGroupe($this);
        }

        return $this;
    }

    public function removeInscription(TInscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getGroupe() === $this) {
                $inscription->setGroupe(null);
            }
        }

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
            $emptime->setGroupe($this);
        }

        return $this;
    }

    public function removeEmptime(PlEmptime $emptime): self
    {
        if ($this->emptimes->removeElement($emptime)) {
            // set the owning side to null (unless already changed)
            if ($emptime->getGroupe() === $this) {
                $emptime->setGroupe(null);
            }
        }

        return $this;
    }
}
