<?php

namespace App\Entity;

use App\Repository\TPreinscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TPreinscriptionRepository::class)]
class TPreinscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: PStatut::class)]
    private $statut;

    #[ORM\ManyToOne(targetEntity: TEtudiant::class, inversedBy: 'preinscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private $etudiant;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $inscriptionValide;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $rangP;

    #[ORM\Column(type: 'integer')]
    private $rangS;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $active;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $mentionnerAdmissible;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\OneToMany(mappedBy: 'preinscription', targetEntity: TAdmission::class)]
    private $admissions;

    #[ORM\ManyToOne(targetEntity: AcAnnee::class, inversedBy: 'preinscriptions')]
    private $annee;

    #[ORM\ManyToOne(targetEntity: PStatut::class)]
    private $categorieListe;

    #[ORM\ManyToOne(targetEntity: PStatut::class)]
    private $admissionListe;
    #[ORM\OneToMany(mappedBy: 'preinscription', targetEntity: TOperationcab::class)]
    private $operationcabs;
    #[ORM\OneToMany(mappedBy: 'preinscription', targetEntity: TAdmissionDocument::class)]
    private $admissionDocuments;

    #[ORM\ManyToMany(targetEntity: PDocument::class, inversedBy: 'preinscriptions')]
    private $documents;

    #[ORM\ManyToOne(targetEntity: NatureDemande::class, inversedBy: 'preinscriptions')]
    private $nature;

    #[ORM\ManyToOne(targetEntity: user::class, inversedBy: 'tPreinscriptions')]
    private $userAnnulated;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $annulated;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'Preinscriptions')]
    private $userCreated;

    // #[ORM\Column(type: 'float', nullable: true)]
    // private $validation;


    public function __construct()
    {
        $this->admissions = new ArrayCollection();
        $this->operationcabs = new ArrayCollection();
        $this->admissionDocuments = new ArrayCollection();
        $this->Documents = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?PStatut
    {
        return $this->statut;
    }

    public function setStatut(?PStatut $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getEtudiant(): ?TEtudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?TEtudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

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

    public function getInscriptionValide(): ?int
    {
        return $this->inscriptionValide;
    }

    public function setInscriptionValide(?int $inscriptionValide): self
    {
        $this->inscriptionValide = $inscriptionValide;

        return $this;
    }

    public function getRangP(): ?int
    {
        return $this->rangP;
    }

    public function setRangP(?int $rangP): self
    {
        $this->rangP = $rangP;

        return $this;
    }

    public function getRangS(): ?int
    {
        return $this->rangS;
    }

    public function setRangS(int $rangS): self
    {
        $this->rangS = $rangS;

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

    public function getMentionnerAdmissible(): ?int
    {
        return $this->mentionnerAdmissible;
    }

    public function setMentionnerAdmissible(?int $mentionnerAdmissible): self
    {
        $this->mentionnerAdmissible = $mentionnerAdmissible;

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
            $admission->setPreinscription($this);
        }

        return $this;
    }

    public function removeAdmission(TAdmission $admission): self
    {
        if ($this->admissions->removeElement($admission)) {
            // set the owning side to null (unless already changed)
            if ($admission->getPreinscription() === $this) {
                $admission->setPreinscription(null);
            }
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

    public function getCategorieListe(): ?PStatut
    {
        return $this->categorieListe;
    }

    public function setCategorieListe(?PStatut $categorieListe)
    {
        $this->categorieListe = $categorieListe;
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
            $operationcab->setPreinscription($this);
        }


        return $this;
    }

    public function getAdmissionListe(): ?PStatut
    {
        return $this->admissionListe;
    }

    public function setAdmissionListe(?PStatut $admissionListe)
    {
        $this->admissionListe = $admissionListe;
    }
    public function removeOperationcab(TOperationcab $operationcab): self
    {
        if ($this->operationcabs->removeElement($operationcab)) {
            // set the owning side to null (unless already changed)
            if ($operationcab->getPreinscription() === $this) {
                $operationcab->setPreinscription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TAdmissionDocument[]
     */
    public function getAdmissionDocuments(): Collection
    {
        return $this->admissionDocuments;
    }

    public function addAdmissionDocument(TAdmissionDocument $admissionDocument): self
    {
        if (!$this->admissionDocuments->contains($admissionDocument)) {
            $this->admissionDocuments[] = $admissionDocument;
            $admissionDocument->setPreinscription($this);
        }

        return $this;
    }

    public function removeAdmissionDocument(TAdmissionDocument $admissionDocument): self
    {
        if ($this->admissionDocuments->removeElement($admissionDocument)) {
            // set the owning side to null (unless already changed)
            if ($admissionDocument->getPreinscription() === $this) {
                $admissionDocument->setPreinscription(null);
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
        }

        return $this;
    }

    public function removeDocument(PDocument $document): self
    {
        $this->documents->removeElement($document);

        return $this;
    }

    public function getNature(): ?NatureDemande
    {
        return $this->nature;
    }

    public function setNature(?NatureDemande $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    // public function getValidation(): ?float
    // {
    //     return $this->validation;
    // }

    // public function setValidation(?float $validation): self
    // {
    //     $this->validation = $validation;

    //     return $this;
    // }

    public function getUserAnnulated(): ?user
    {
        return $this->userAnnulated;
    }

    public function setUserAnnulated(?user $userAnnulated): self
    {
        $this->userAnnulated = $userAnnulated;

        return $this;
    }

    public function getAnnulated(): ?\DateTimeInterface
    {
        return $this->annulated;
    }

    public function setAnnulated(?\DateTimeInterface $annulated): self
    {
        $this->annulated = $annulated;

        return $this;
    }

    public function getUserCreated(): ?User
    {
        return $this->userCreated;
    }

    public function setUserCreated(?User $userCreated): self
    {
        $this->userCreated = $userCreated;

        return $this;
    }
}
