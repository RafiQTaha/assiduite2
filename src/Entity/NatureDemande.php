<?php

namespace App\Entity;

use App\Repository\NatureDemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NatureDemandeRepository::class)]
class NatureDemande
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

    #[ORM\Column(type: 'integer', nullable: true)]
    private $concours;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $rapport;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $rapport_ordre;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $active;

    #[ORM\OneToMany(mappedBy: 'natureDemande', targetEntity: TEtudiant::class)]
    private $etudiants;

    #[ORM\OneToMany(mappedBy: 'natureDemande', targetEntity: PDocument::class)]
    private $documents;

    #[ORM\OneToMany(mappedBy: 'nature', targetEntity: TPreinscription::class)]
    private $preinscriptions;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->preinscriptions = new ArrayCollection();
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

    public function getConcours(): ?int
    {
        return $this->concours;
    }

    public function setConcours(?int $concours): self
    {
        $this->concours = $concours;

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

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(?int $active): self
    {
        $this->active = $active;

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
            $etudiant->setNatureDemande($this);
        }

        return $this;
    }

    public function removeEtudiant(TEtudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getNatureDemande() === $this) {
                $etudiant->setNatureDemande(null);
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
            $document->setNatureDemande($this);
        }

        return $this;
    }

    public function removeDocument(PDocument $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getNatureDemande() === $this) {
                $document->setNatureDemande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TPreinscription>
     */
    public function getPreinscriptions(): Collection
    {
        return $this->preinscriptions;
    }

    public function addPreinscription(TPreinscription $preinscription): self
    {
        if (!$this->preinscriptions->contains($preinscription)) {
            $this->preinscriptions[] = $preinscription;
            $preinscription->setNature($this);
        }

        return $this;
    }

    public function removePreinscription(TPreinscription $preinscription): self
    {
        if ($this->preinscriptions->removeElement($preinscription)) {
            // set the owning side to null (unless already changed)
            if ($preinscription->getNature() === $this) {
                $preinscription->setNature(null);
            }
        }

        return $this;
    }
}
