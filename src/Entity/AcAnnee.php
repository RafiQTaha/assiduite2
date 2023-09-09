<?php

namespace App\Entity;

use App\Repository\AcAnneeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AcAnneeRepository::class)]
class AcAnnee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_created;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_updated;

    #[ORM\ManyToOne(targetEntity: AcFormation::class, inversedBy: 'acAnnees')]
    private $formation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $active;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $annee_active_ues;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $validation_academique;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $cloture_academique;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\OneToMany(mappedBy: 'annee', targetEntity: TPreinscription::class)]
    private $preinscriptions;

    #[ORM\OneToMany(mappedBy: 'annee', targetEntity: TInscription::class)]
    private $inscriptions;

    #[ORM\OneToMany(mappedBy: 'annee', targetEntity: TOperationcab::class)]
    private $operationcabs;

    #[ORM\OneToMany(mappedBy: 'annee', targetEntity: AcEpreuve::class)]
    private $epreuves;

    #[ORM\OneToMany(mappedBy: 'annee', targetEntity: ExControle::class)]
    private $controles;

    #[ORM\OneToMany(mappedBy: 'annee', targetEntity: PrProgrammation::class)]
    private $programmations;

    #[ORM\OneToMany(mappedBy: 'annee', targetEntity: AnoteExterne::class)]
    private $anoteExternes;

    #[ORM\OneToMany(mappedBy: 'annee', targetEntity: Pv::class)]
    private $pvs;

    public function __construct()
    {
        $this->preinscriptions = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->operationcabs = new ArrayCollection();
        $this->epreuves = new ArrayCollection();
        $this->controles = new ArrayCollection();
        $this->programmations = new ArrayCollection();
        $this->note = new ArrayCollection();
        $this->anoteExternes = new ArrayCollection();
        $this->pvs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserCreated(): ?User
    {
        return $this->user_created;
    }

    public function setUserCreated(?User $user_created): self
    {
        $this->user_created = $user_created;

        return $this;
    }

    public function getUserUpdated(): ?User
    {
        return $this->user_updated;
    }

    public function setUserUpdated(?User $user_updated): self
    {
        $this->user_updated = $user_updated;

        return $this;
    }

    public function getFormation(): ?AcFormation
    {
        return $this->formation;
    }

    public function setFormation(?AcFormation $formation): self
    {
        $this->formation = $formation;

        return $this;
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

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(?int $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getAnneeActiveUes(): ?int
    {
        return $this->annee_active_ues;
    }

    public function setAnneeActiveUes(?int $annee_active_ues): self
    {
        $this->annee_active_ues = $annee_active_ues;

        return $this;
    }

    public function getValidationAcademique(): ?string
    {
        return $this->validation_academique;
    }

    public function setValidationAcademique(?string $validation_academique): self
    {
        $this->validation_academique = $validation_academique;

        return $this;
    }

    public function getClotureAcademique(): ?string
    {
        return $this->cloture_academique;
    }

    public function setClotureAcademique(?string $cloture_academique): self
    {
        $this->cloture_academique = $cloture_academique;

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
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

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
            $preinscription->setAnnee($this);
        }

        return $this;
    }

    public function removePreinscription(TPreinscription $preinscription): self
    {
        if ($this->preinscriptions->removeElement($preinscription)) {
            // set the owning side to null (unless already changed)
            if ($preinscription->getAnnee() === $this) {
                $preinscription->setAnnee(null);
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
            $inscription->setAnnee($this);
        }

        return $this;
    }

    public function removeInscription(TInscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getAnnee() === $this) {
                $inscription->setAnnee(null);
            }
        }

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
            $operationcab->setAnnee($this);
        }

        return $this;
    }

    public function removeOperationcab(TOperationcab $operationcab): self
    {
        if ($this->operationcabs->removeElement($operationcab)) {
            // set the owning side to null (unless already changed)
            if ($operationcab->getAnnee() === $this) {
                $operationcab->setAnnee(null);
            }
        }

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
            $epreufe->setAnnee($this);
        }

        return $this;
    }

    public function removeEpreufe(AcEpreuve $epreufe): self
    {
        if ($this->epreuves->removeElement($epreufe)) {
            // set the owning side to null (unless already changed)
            if ($epreufe->getAnnee() === $this) {
                $epreufe->setAnnee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ExControle[]
     */
    public function getControles(): Collection
    {
        return $this->controles;
    }

    public function addControle(ExControle $controle): self
    {
        if (!$this->controles->contains($controle)) {
            $this->controles[] = $controle;
            $controle->setAnnee($this);
        }

        return $this;
    }

    public function removeControle(ExControle $controle): self
    {
        if ($this->controles->removeElement($controle)) {
            // set the owning side to null (unless already changed)
            if ($controle->getAnnee() === $this) {
                $controle->setAnnee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PrProgrammation>
     */
    public function getProgrammations(): Collection
    {
        return $this->programmations;
    }

    public function addProgrammation(PrProgrammation $programmation): self
    {
        if (!$this->programmations->contains($programmation)) {
            $this->programmations[] = $programmation;
            $programmation->setAnnee($this);
        }

        return $this;
    }

    public function removeProgrammation(PrProgrammation $programmation): self
    {
        if ($this->programmations->removeElement($programmation)) {
            // set the owning side to null (unless already changed)
            if ($programmation->getAnnee() === $this) {
                $programmation->setAnnee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AnoteExterne>
     */
    public function getAnoteExternes(): Collection
    {
        return $this->anoteExternes;
    }

    public function addAnoteExterne(AnoteExterne $anoteExterne): self
    {
        if (!$this->anoteExternes->contains($anoteExterne)) {
            $this->anoteExternes[] = $anoteExterne;
            $anoteExterne->setAnnee($this);
        }

        return $this;
    }

    public function removeAnoteExterne(AnoteExterne $anoteExterne): self
    {
        if ($this->anoteExternes->removeElement($anoteExterne)) {
            // set the owning side to null (unless already changed)
            if ($anoteExterne->getAnnee() === $this) {
                $anoteExterne->setAnnee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pv>
     */
    public function getPvs(): Collection
    {
        return $this->pvs;
    }

    public function addPv(Pv $pv): self
    {
        if (!$this->pvs->contains($pv)) {
            $this->pvs[] = $pv;
            $pv->setAnnee($this);
        }

        return $this;
    }

    public function removePv(Pv $pv): self
    {
        if ($this->pvs->removeElement($pv)) {
            // set the owning side to null (unless already changed)
            if ($pv->getAnnee() === $this) {
                $pv->setAnnee(null);
            }
        }

        return $this;
    }

}
