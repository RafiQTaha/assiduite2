<?php

namespace App\Entity;

use App\Entity\PFrais;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\POrganismeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: POrganismeRepository::class)]
class POrganisme
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

    #[ORM\Column(type: 'boolean')]
    private $active;

    #[ORM\OneToMany(mappedBy: 'organisme', targetEntity: TOperationcab::class)]
    private $operationcabs;

    #[ORM\OneToMany(mappedBy: 'organisme', targetEntity: TEtudiant::class)]
    private $etudiants;

    #[ORM\OneToMany(mappedBy: 'organisme', targetEntity: TOperationdet::class)]
    private $operationdets;

    

    public function __construct()
    {
        $this->operationcabs = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
        $this->operationdets = new ArrayCollection();
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

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|TOperationcab[]
     */
    public function getOperationcabs(): Collection
    {
        return $this->operationcabs;
    }

    public function addOperationcab(TOperationcab $operationcab): self
    {
        if (!$this->operationcabs->contains($operationcab)) {
            $this->operationcabs[] = $operationcab;
            $operationcab->setOrganisme($this);
        }

        return $this;
    }

    public function removeOperationcab(TOperationcab $operationcab): self
    {
        if ($this->operationcabs->removeElement($operationcab)) {
            // set the owning side to null (unless already changed)
            if ($operationcab->getOrganisme() === $this) {
                $operationcab->setOrganisme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TEtudiant[]
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(TEtudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setOrganisme($this);
        }

        return $this;
    }

    public function removeEtudiant(TEtudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getOrganisme() === $this) {
                $etudiant->setOrganisme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TOperationdet>
     */
    public function getOperationdets(): Collection
    {
        return $this->operationdets;
    }

    public function addOperationdet(TOperationdet $operationdet): self
    {
        if (!$this->operationdets->contains($operationdet)) {
            $this->operationdets[] = $operationdet;
            $operationdet->setOrganisme($this);
        }

        return $this;
    }

    public function removeOperationdet(TOperationdet $operationdet): self
    {
        if ($this->operationdets->removeElement($operationdet)) {
            // set the owning side to null (unless already changed)
            if ($operationdet->getOrganisme() === $this) {
                $operationdet->setOrganisme(null);
            }
        }

        return $this;
    }

   
}
