<?php

namespace App\Entity;

use App\Repository\AcEtablissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AcEtablissementRepository::class)]
class AcEtablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_created;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_updated;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $abreviation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $statut;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $doyen;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nature;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $active = 1;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $rapport;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $rapport_ordre;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\OneToMany(mappedBy: 'etablissement', targetEntity: AcFormation::class)]
    private $acFormations;

    #[ORM\OneToMany(mappedBy: 'etablissement', targetEntity: AcDepartement::class)]
    private $acDepartements;

    #[ORM\OneToMany(mappedBy: 'etablissement', targetEntity: PDocument::class)]
    private $documents;

    #[ORM\OneToMany(mappedBy: 'etablissement', targetEntity: TBrdpaiement::class)]
    private $bordereaux;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designationEn;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $statutEn;

    #[ORM\Column(type: 'integer')]
    private $assiduite;

    public function __construct()
    {
        $this->acFormations = new ArrayCollection();
        $this->acDepartements = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->bordereaux = new ArrayCollection();
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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDoyen(): ?string
    {
        return $this->doyen;
    }

    public function setDoyen(?string $doyen): self
    {
        $this->doyen = $doyen;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getRapport(): ?int
    {
        return $this->rapport;
    }

    public function setRapport(?int $rapport): self
    {
        $this->rapport = $rapport;

        return $this;
    }

    public function getRapportOrdre(): ?int
    {
        return $this->rapport_ordre;
    }

    public function setRapportOrdre(?int $rapport_ordre): self
    {
        $this->rapport_ordre = $rapport_ordre;

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
     * @return Collection|AcFormation[]
     */
    public function getAcFormations(): Collection
    {
        return $this->acFormations;
    }

    public function addAcFormation(AcFormation $acFormation): self
    {
        if (!$this->acFormations->contains($acFormation)) {
            $this->acFormations[] = $acFormation;
            $acFormation->setEtablissement($this);
        }

        return $this;
    }

    public function removeAcFormation(AcFormation $acFormation): self
    {
        if ($this->acFormations->removeElement($acFormation)) {
            // set the owning side to null (unless already changed)
            if ($acFormation->getEtablissement() === $this) {
                $acFormation->setEtablissement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AcDepartement[]
     */
    public function getAcDepartements(): Collection
    {
        return $this->acDepartements;
    }

    public function addAcDepartement(AcDepartement $acDepartement): self
    {
        if (!$this->acDepartements->contains($acDepartement)) {
            $this->acDepartements[] = $acDepartement;
            $acDepartement->setEtablissement($this);
        }

        return $this;
    }

    public function removeAcDepartement(AcDepartement $acDepartement): self
    {
        if ($this->acDepartements->removeElement($acDepartement)) {
            // set the owning side to null (unless already changed)
            if ($acDepartement->getEtablissement() === $this) {
                $acDepartement->setEtablissement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PDocument[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(PDocument $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setEtablissement($this);
        }

        return $this;
    }

    public function removeDocument(PDocument $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getEtablissement() === $this) {
                $document->setEtablissement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TBrdpaiement[]
     */
    public function getBordereaux(): Collection
    {
        return $this->bordereaux;
    }

    public function addBordereaux(TBrdpaiement $bordereaux): self
    {
        if (!$this->bordereaux->contains($bordereaux)) {
            $this->bordereaux[] = $bordereaux;
            $bordereaux->setEtablissement($this);
        }

        return $this;
    }

    public function removeBordereaux(TBrdpaiement $bordereaux): self
    {
        if ($this->bordereaux->removeElement($bordereaux)) {
            // set the owning side to null (unless already changed)
            if ($bordereaux->getEtablissement() === $this) {
                $bordereaux->setEtablissement(null);
            }
        }

        return $this;
    }

    public function getDesignationEn(): ?string
    {
        return $this->designationEn;
    }

    public function setDesignationEn(?string $designationEn): self
    {
        $this->designationEn = $designationEn;

        return $this;
    }

    public function getStatutEn(): ?string
    {
        return $this->statutEn;
    }

    public function setStatutEn(?string $statutEn): self
    {
        $this->statutEn = $statutEn;

        return $this;
    }

    public function getAssiduite(): ?int
    {
        return $this->assiduite;
    }

    public function setAssiduite(int $assiduite): self
    {
        $this->assiduite = $assiduite;

        return $this;
    }

}
