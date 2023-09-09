<?php

namespace App\Entity;

use App\Repository\PStatutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PStatutRepository::class)]
class PStatut
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $abreviation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $table0;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $phase0;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $visible;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $visibleAdmission;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $next;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $active;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $anuller;

    #[ORM\OneToMany(mappedBy: 'statut', targetEntity: TEtudiant::class)]
    private $etudiants;

    #[ORM\OneToMany(mappedBy: 'statutDeliberation', targetEntity: TPreinscription::class)]
    private $preinscriptions;

    #[ORM\OneToMany(mappedBy: 'statut', targetEntity: TAdmission::class)]
    private $admissions;

    #[ORM\OneToMany(mappedBy: 'statut', targetEntity: TInscription::class)]
    private $inscriptions;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->preinscriptions = new ArrayCollection();
        $this->admissions = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
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

    public function getTable0(): ?string
    {
        return $this->table0;
    }

    public function setTable0(?string $table0): self
    {
        $this->table0 = $table0;

        return $this;
    }

    public function getPhase0(): ?string
    {
        return $this->phase0;
    }

    public function setPhase0(?string $phase0): self
    {
        $this->phase0 = $phase0;

        return $this;
    }

    public function getVisible(): ?int
    {
        return $this->visible;
    }

    public function setVisible(?int $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getVisibleAdmission(): ?int
    {
        return $this->visibleAdmission;
    }

    public function setVisibleAdmission(?int $visibleAdmission): self
    {
        $this->visibleAdmission = $visibleAdmission;

        return $this;
    }

    public function getNext(): ?string
    {
        return $this->next;
    }

    public function setNext(?string $next): self
    {
        $this->next = $next;

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

    public function getAnuller(): ?int
    {
        return $this->anuller;
    }

    public function setAnuller(?int $anuller): self
    {
        $this->anuller = $anuller;

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
            $etudiant->setStatut($this);
        }

        return $this;
    }

    public function removeEtudiant(TEtudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getStatut() === $this) {
                $etudiant->setStatut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TPreinscription[]
     */
    public function getPreinscriptions(): Collection
    {
        return $this->preinscriptions;
    }

    public function addPreinscription(TPreinscription $preinscription): self
    {
        if (!$this->preinscriptions->contains($preinscription)) {
            $this->preinscriptions[] = $preinscription;
            $preinscription->setStatutDeliberation($this);
        }

        return $this;
    }

    public function removePreinscription(TPreinscription $preinscription): self
    {
        if ($this->preinscriptions->removeElement($preinscription)) {
            // set the owning side to null (unless already changed)
            if ($preinscription->getStatutDeliberation() === $this) {
                $preinscription->setStatutDeliberation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TAdmission[]
     */
    public function getAdmissions(): Collection
    {
        return $this->admissions;
    }

    public function addAdmission(TAdmission $admission): self
    {
        if (!$this->admissions->contains($admission)) {
            $this->admissions[] = $admission;
            $admission->setStatut($this);
        }

        return $this;
    }

    public function removeAdmission(TAdmission $admission): self
    {
        if ($this->admissions->removeElement($admission)) {
            // set the owning side to null (unless already changed)
            if ($admission->getStatut() === $this) {
                $admission->setStatut(null);
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
            $inscription->setStatut($this);
        }

        return $this;
    }

    public function removeInscription(TInscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getStatut() === $this) {
                $inscription->setStatut(null);
            }
        }

        return $this;
    }
}
